#In this example i will enroll people face against a given aadhar
import face_recognition
import glob, os
import sys

if len(sys.argv) != 2:
    print('{"code":"Invalid Request"}')
    exit()


aadhar = sys.argv[1]
os.chdir('/var/www/html/newlive/'+aadhar)

for file in glob.glob('*.jpg'):
 xfile = file
 filename = xfile+'_.txt'
 obama_image = face_recognition.load_image_file("/var/www/html/newlive/"+aadhar+"/"+xfile)

 face_descriptor = face_recognition.face_encodings(obama_image)
 if len(face_descriptor) == 1:
     for number in face_descriptor[0]:
         thefile = open(filename, 'a')
         thefile.write("%s," % number) # Saving only 2.1KB of text file of encoded string (This will highly saves the sevrer space as image is now not required)
         thefile.close()
     #os.remove(xfile)    # Removing the image for security and saving server space
     with open(filename, 'rb+') as filehandle:
         filehandle.seek(-1, os.SEEK_END)
         filehandle.truncate()
         filehandle.close()
     print('{"code":"Success"}')
 else:
     print('{"code":"Unsuccess"}')

for file in glob.glob('*.png'):
 xfile = file
 filename = xfile+'_.txt'
 obama_image = face_recognition.load_image_file("/var/www/html/newlive/"+aadhar+"/"+xfile)

 face_descriptor = face_recognition.face_encodings(obama_image)
 if len(face_descriptor) == 1:
     for number in face_descriptor[0]:
         thefile = open(filename, 'a')
         thefile.write("%s," % number) # Saving only 2.1KB of text file of encoded string (This will highly saves the sevrer space as image is now not required)
         thefile.close()
     #os.remove(xfile)    # Removing the image for security and saving server space
     with open(filename, 'rb+') as filehandle:
         filehandle.seek(-1, os.SEEK_END)
         filehandle.truncate()
         filehandle.close()
     print('{"code":"Success"}')
 else:
     print('{"code":"Unsuccess"}')
     

for file in glob.glob('*.jpeg'):
 xfile = file
 filename = xfile+'_.txt'
 obama_image = face_recognition.load_image_file("/var/www/html/newlive/"+aadhar+"/"+xfile)

 face_descriptor = face_recognition.face_encodings(obama_image)
 if len(face_descriptor) == 1:
     for number in face_descriptor[0]:
         thefile = open(filename, 'a')
         thefile.write("%s," % number) # Saving only 2.1KB of text file of encoded string (This will highly saves the sevrer space as image is now not required)
         thefile.close()
     #os.remove(xfile)    # Removing the image for security and saving server space
     with open(filename, 'rb+') as filehandle:
         filehandle.seek(-1, os.SEEK_END)
         filehandle.truncate()
         filehandle.close()
     print('{"code":"Success"}')
 else:
     print('{"code":"Unsuccess"}')
     
for file in glob.glob('*.JPG'):
 xfile = file
 filename = xfile+'_.txt'
 obama_image = face_recognition.load_image_file("/var/www/html/newlive/"+aadhar+"/"+xfile)

 face_descriptor = face_recognition.face_encodings(obama_image)
 if len(face_descriptor) == 1:
     for number in face_descriptor[0]:
         thefile = open(filename, 'a')
         thefile.write("%s," % number) # Saving only 2.1KB of text file of encoded string (This will highly saves the sevrer space as image is now not required)
         thefile.close()
     #os.remove(xfile)    # Removing the image for security and saving server space
     with open(filename, 'rb+') as filehandle:
         filehandle.seek(-1, os.SEEK_END)
         filehandle.truncate()
         filehandle.close()
     print('{"code":"Success"}')
 else:
     print('{"code":"Unsuccess"}')
     
for file in glob.glob('*.PNG'):
 xfile = file
 filename = xfile+'_.txt'
 obama_image = face_recognition.load_image_file("/var/www/html/newlive/"+aadhar+"/"+xfile)

 face_descriptor = face_recognition.face_encodings(obama_image)
 if len(face_descriptor) == 1:
     for number in face_descriptor[0]:
         thefile = open(filename, 'a')
         thefile.write("%s," % number) # Saving only 2.1KB of text file of encoded string (This will highly saves the sevrer space as image is now not required)
         thefile.close()
     #os.remove(xfile)    # Removing the image for security and saving server space
     with open(filename, 'rb+') as filehandle:
         filehandle.seek(-1, os.SEEK_END)
         filehandle.truncate()
         filehandle.close()
     print('{"code":"Success"}')
 else:
     print('{"code":"Unsuccess"}')
     
     
for file in glob.glob('*.JPEG'):
 xfile = file
 filename = xfile+'_.txt'
 obama_image = face_recognition.load_image_file("/var/www/html/newlive/"+aadhar+"/"+xfile)

 face_descriptor = face_recognition.face_encodings(obama_image)
 if len(face_descriptor) == 1:
     for number in face_descriptor[0]:
         thefile = open(filename, 'a')
         thefile.write("%s," % number) # Saving only 2.1KB of text file of encoded string (This will highly saves the sevrer space as image is now not required)
         thefile.close()
     #os.remove(xfile)    # Removing the image for security and saving server space
     with open(filename, 'rb+') as filehandle:
         filehandle.seek(-1, os.SEEK_END)
         filehandle.truncate()
         filehandle.close()
     print('{"code":"Success"}')
 else:
     print('{"code":"Unsuccess"}')


