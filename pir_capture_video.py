#!/usr/bin/env python
import picamera
from time import sleep
import subprocess
import RPIO

photosensor_pin = 7 #GPIO 7, physical pin 26
RPIO.setmode(RPIO.BCM)
#set up input channel without pull-up
RPIO.setup(photosensor_pin, RPIO.IN)

#read input from gpio 7
input_value = RPIO.input(photosensor_pin)
flag1 = 0

def isr1(gpio_id,val):
	print ("motion detected")
	print ("gpio %s: %s" % (gpio_id,val))	
	global flag1
	flag1 = 1
	print ("flag1 = %d" % flag1)
	videorecord()

def videorecord():
	global flag1
	flag1 = 0
	print ("recording video now")
	camera=picamera.PiCamera() #instance of Picamera class
	camera.start_recording('/var/www/videos/testclip2.h264')
	sleep(20)
	camera.stop_recording()
        subprocess.call('sudo MP4Box -add /var/www/videos/testclip2.h264 /var/www/videos/testclip2.mp4',shell=True)
	print ("recording stopped")
	print ("Now flag1 = %d" % flag1)



photosensor_pin = 7 #GPIO 7, physical pin 26
RPIO.setmode(RPIO.BCM)

#set up input channel without pull-up
RPIO.setup(photosensor_pin, RPIO.IN)

#read input from gpio 7
input_value = RPIO.input(photosensor_pin)

print "photocell value= %d" % input_value


RPIO.add_interrupt_callback(photosensor_pin,isr1,edge='falling',pull_up_down=RPIO.PUD_UP,threaded_callback=False,debounce_timeout_ms=50)

RPIO.wait_for_interrupts()
