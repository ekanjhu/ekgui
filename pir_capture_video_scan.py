#!/usr/bin/env python
import picamera
from time import sleep
import subprocess
import RPIO
import time
from RPIO import PWM
import send_email
import MySQLdb
import datetime

def isr1(gpio_id,val):
	print ("motion detected")
	print ("gpio %s: %s" % (gpio_id,val))	
	global flag1
	flag1 = 1
	print ("flag1 = %d" % flag1)
	videorecord_withscan()
	send_email.send_email_alert()

def videorecord_withscan():
	global flag1
	flag1 = 0

	pwm_pin = 18
	print ("recording video now")
	
	#Get current timestamp and format to be part of filename
        st1 = str(datetime.datetime.now()).split(".")[0]
        st2 = str(st1).replace("-","")
        st3 = str(st2).replace(":","")
        datestring = str(st3).replace(" ","_")

        h264name = filepath + filename_prefix + datestring + rawextension
        mp4name  = filepath + filename_prefix + datestring + dbextension
        table_filename = filename_prefix + datestring + dbextension

	camera=picamera.PiCamera() #instance of Picamera class
	camera.start_recording(h264name);
	
	#Clockwise rotation
	for x in xrange(0,15):
        	print ("position %d" % (x))
        	pulse_duration = 900+80*x
        	print ("new pulse-width=%f" % (pulse_duration))
        	servo.set_servo(pwm_pin,pulse_duration)
        	time.sleep(1)  # wait for 1-seconds

	#Counter Clockwise rotation
	for xback in xrange(1,15):
        	print ("position %d" % (xback))
        	pulse_duration = 2100-80*xback
        	print ("new pulse-width=%f" % (pulse_duration))
        	servo.set_servo(pwm_pin,pulse_duration)
        	time.sleep(1)  # wait for 1-seconds

	#Clear servo on GPIO17
	servo.stop_servo(pwm_pin)

	camera.stop_recording()
        #subprocess.call('sudo MP4Box -add /var/www/videos/testclip2.h264 /var/www/videos/testclip2.mp4',shell=True)
	subprocess.call("sudo MP4Box -add "+ h264name + " " + mp4name,shell=True)
	
	#insert filename into recorded_video mysql table
	cursor.execute("""INSERT INTO recorded_video (date,time,viewedStatus,link) VALU$
	db.commit()
	db.close()

	print ("recording stopped")
	print ("Now flag1 = %d" % flag1)


servername = "localhost"
username = "root"
password = "Ek5rpid6"
dbname = "light_status"

filename_prefix   = 'vid_'
table_name = 'recorded_video'
filepath   = '/var/www/videos/'
rawextension = '.h264'
dbextension  = '.mp4'

#Open Database connection
db = MySQLdb.connect(servername,username,password,dbname)

#prepare a cursor object using cursor() method
cursor = db.cursor()

servo = PWM.Servo()

photosensor_pin = 7 #GPIO 7, physical pin 26
RPIO.setmode(RPIO.BCM)

#set up input channel without pull-up
RPIO.setup(photosensor_pin, RPIO.IN)

#read input from gpio 7
input_value = RPIO.input(photosensor_pin)

print "photocell value= %d" % input_value


RPIO.add_interrupt_callback(photosensor_pin,isr1,edge='falling',pull_up_down=RPIO.PUD_UP,threaded_callback=False,debounce_timeout_ms=50)


RPIO.wait_for_interrupts()
