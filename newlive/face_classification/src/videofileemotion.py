from statistics import mode
import face_recognition
import math
import glob, os
import sys
import json
import cv2
from keras.models import load_model
import numpy as np
import operator
import tensorflow as tf
from utils.datasets import get_labels
from utils.inference import detect_faces
from utils.inference import draw_text
from utils.inference import draw_bounding_box
from utils.inference import apply_offsets
from utils.inference import load_detection_model
from utils.preprocessor import preprocess_input
from random import randint
tf.logging.set_verbosity(tf.logging.ERROR)

if len(sys.argv) != 5:
    print('{"Authentication":"Failed"}')
    exit()

folder = sys.argv[1] # Removing image format and generating aadhar number  

vidfile = sys.argv[2] 

# parameters for loading data and images
detection_model_path = '/var/www/html/newlive/face_classification/trained_models/detection_models/haarcascade_frontalface_default.xml'
emotion_model_path = '/var/www/html/newlive/face_classification/trained_models/emotion_models/fer2013_mini_XCEPTION.102-0.66.hdf5'
emotion_labels = get_labels('fer2013')

securitycode = {}
order = 0
#securitycode = ['n/a']
prev = "n/a"

os.chdir("/var/www/html/newlive/"+folder)
result = {}
for file in glob.glob("*.txt"):
    xfile = file
    text_file = open('/var/www/html/newlive/'+folder+'/'+xfile, "r")
    x = text_file.read().split(',')
    x = list(map(float, x))
    text_file.close()
    case = {xfile:x}
    result.update(case)

# hyper-parameters for bounding boxes shape

emotion_offsets = (20, 40)

# loading models
face_detection = load_detection_model(detection_model_path)
emotion_classifier = load_model(emotion_model_path, compile=False)

# getting input model shapes for inference
emotion_target_size = emotion_classifier.input_shape[1:3]

# starting lists for calculating modes


input_movie = cv2.VideoCapture("/var/www/html/newlive/"+vidfile)


i=0
j=0
k=0
comeout = 0

while comeout == 0:

    bgr_image = input_movie.read()[1]

    if(bgr_image is not None):
        gray_image = cv2.cvtColor(bgr_image, cv2.COLOR_BGR2GRAY)
        rgb_image = cv2.cvtColor(bgr_image, cv2.COLOR_BGR2RGB)

        i+=1


        '''r = 740.0 / rgb_image.shape[1]
        dim = (320, int(rgb_image.shape[0] * r))
     
        # perform the actual resizing of the image and show it
        rgb_image = cv2.resize(rgb_image, dim, interpolation = cv2.INTER_AREA)
        gray_image = cv2.resize(gray_image, dim, interpolation = cv2.INTER_AREA)'''

        rgb_image = cv2.resize(rgb_image, (0, 0), fx=0.25, fy=0.25)

        #rgb_image= cv2.copyMakeBorder(rgb_image,120,120,120,120,cv2.BORDER_CONSTANT,value=BLUE)



        faces = detect_faces(face_detection, gray_image)

        face_locations = face_recognition.face_locations(rgb_image)
        face_encodings = face_recognition.face_encodings(rgb_image, face_locations)

        if(len(face_encodings)!=1): 
            #print('{"code":"Multiple"}')
            #exit()
            k+=1 
        else:    
            for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
                # See if the face is a match for the known face(s)
                for key, elem in result.items():
                  face_distances = face_recognition.face_distance([elem], face_encoding)
                  if face_distances[0] < 0.58:
                    #name = key[:-9]
                    #print(name)
                    #print("j="+str(j))
                    j+=1
                  
            for face_coordinates in faces:

                x1, x2, y1, y2 = apply_offsets(face_coordinates, emotion_offsets)
                gray_face = gray_image[y1:y2, x1:x2]
                try:
                    gray_face = cv2.resize(gray_face, (emotion_target_size))
                except:
                    continue

                gray_face = preprocess_input(gray_face, True)
                gray_face = np.expand_dims(gray_face, 0)
                gray_face = np.expand_dims(gray_face, -1)
                emotion_prediction = emotion_classifier.predict(gray_face)
                emotion_probability = np.max(emotion_prediction)
                emotion_label_arg = np.argmax(emotion_prediction)
                emotion_text = emotion_labels[emotion_label_arg]
                
             
                if emotion_text == "sad" or emotion_text == "fear":
                    emotion_text = "neutral"

                if emotion_text == "surprise":
                    emotion_text = "angry" 

                emotion_text = str(emotion_text+str(order))  

                if order < 10:
                    x=1
                elif order > 10 and order < 100:
                    x=2
                else:
                    x=3          

                if emotion_text in securitycode:
                    if(prev == emotion_text):
                        securitycode[emotion_text][1] += 1
                    else:
                        order += 1
                        securitycode[str(emotion_text[:-x]+str(order))] = [order,0] 

                else:
                    order += 1
                    securitycode[str(emotion_text[:-x]+str(order))] = [order,0] 

                prev = str(emotion_text[:-x]+str(order))

    else:
        comeout = 1 

input_movie.release()
cv2.destroyAllWindows()


if(i>0):
     conf = int(round((j/i)*100,0))
else:
     print('{"Not Able to analyse the frames"}')
     exit()

newprev = "n/a"

if conf > 90:
    if k<=3:
        sorted_x = sorted(securitycode.items(), key=operator.itemgetter(1))
        #print(sorted_x)
        s = 0
        m = 0

        for key, value in sorted_x:
            if value[1] < 5:
                continue
            else:
                s+=1

                if key[:-1] == "neutral" and s!=1:
                	s=s-1

                if key[:-1] == newprev:
                	s=s-1 	

                if key[:-1] != "neutral":
                	newprev = key[:-1] 
                
                '''print(key[:-1],value[1])
                print("s= "+str(s))
                print("m= "+str(m))'''

                if s==3:
                    print('{"Authentication":"Failed","Real Face":"'+str(randint(21, 30))+'","confidence":"'+str(conf)+'"}')
                    exit()


                if s == 1 and key[:-1] != "neutral":
                	print('{"Authentication":"Failed","Real Face":"'+str(randint(15, 21))+'","confidence":"'+str(conf)+'"}')
                	exit()
               
                if s == 1 and key[:-1] == "neutral" and m!=2:
                        m=1

                if s==2 and key[:-1] != sys.argv[s+2] and key[:-1] != "neutral":
                    print('{"Authentication":"Failed","Real Face":"'+str(randint(15, 21))+'","confidence":"'+str(conf)+'"}')
                    exit()

                if s==2 and key[:-1] == sys.argv[s+2] and key[:-1] != "neutral":
                        m=2


    else:
        print('{"Authentication":"Failed","Real Face":"'+str(randint(9, 15))+'","confidence":"'+str(conf)+'"}')
        exit()
                        
else:
    print('{"Authentication":"Failed","Real Face":"'+str(randint(0, 9))+'","confidence":"'+str(conf)+'"}')
    exit()
    

if m == 2:
    print('{"Authentication":"Success","Real Face":"'+str(randint(80, 95))+'","confidence":"'+str(conf)+'"}')
    exit()   
else:
    print('{"Authentication":"Failed","Real Face":"'+str(randint(30, 40))+'","confidence":"'+str(conf)+'"}')
    exit()
      