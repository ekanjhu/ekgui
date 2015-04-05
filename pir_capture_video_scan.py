#!/usr/bin/env python
import picamera
from time import sleep
import subprocess
import RPIO
import time
from RPIO import PWM

def isr1(gpio_id,val):
	print ("motion detected")
	print ("gpio %s: %s" % (gpio_id,val))	
	global flag1
	flag1 = 1
	print ("flag1 = %d" % flag1)
	videorecord_withscan()

def videorecord_withscan():
	global flag1
	flag1 = 0

	pwm_pin = 18
	print ("recording video now")
	camera=picamera.PiCamera() #instance of Picamera class
	camera.start_recording('/var/www/videos/testclip2.h264')
	
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
        subprocess.call('sudo MP4Box -add /var/www/videos/testclip2.h264 /var/www/videos/testclip2.mp4',shell=True)
	print ("recording stopped")
	print ("Now flag1 = %d" % flag1)


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
