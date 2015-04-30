#!/usr/bin/env python
import sys
import time
import datetime
import RPi.GPIO as GPIO
import MySQLdb

def time_lights2(argv1,argv2):
	room2_LED = 23

	#Set up for connection to room2 light table
	servername = 'localhost'
	username   = 'root'
        password   = 'Ek5rpid6'
        dbname     = 'light_status'

        tableName= 'table_for_room2'

        #Open Database connection
        db = MySQLdb.connect(servername,username,password,dbname)

        #prepare a cursor object using cursor() method
        cursor = db.cursor()


	#setup GPIO pins as outputs
	GPIO.setmode(GPIO.BOARD)
	GPIO.setup(room2_LED, GPIO.OUT)
	#GPIO.setup(room2_LED, GPIO.OUT)

	#day_val = argv[0]
	ontime  = argv1
	offtime = argv2
	#print "day=%s" % day_val
	print "argv=%s" % ontime
	print "argv=%s" % offtime

	ontimearr = ontime.split(":")
	offtimearr= offtime.split(":")
	
	ontimearr_vals = map(int, ontimearr)
	offtimearr_vals= map(int, offtimearr)

	onhour = ontimearr_vals[0]
	onmin  = ontimearr_vals[1]

	offhour= offtimearr_vals[0]
	offmin = offtimearr_vals[1]

	print "on hour=%d,on min=%d" % (onhour,onmin)
	print "off hour=%d, off min=%d"%(offhour,offmin)
	MonOn = datetime.time(hour=onhour,minute=onmin)
	MonOff= datetime.time(hour=offhour,minute=offmin)

	#store the times in array for easy access
	#OnTime = [MonOn,TuesOn,WedOn,ThuOn,FriOn,SatOn,SunOn]
	#OffTime= [MonOff,TuesOff,WedOff,ThuOff,FriOff,SatOff,SunOff]
	OnTime = [MonOn]
	OffTime= [MonOff]

	while True:
		#get the current time in hours, minutes and seconds
		currTime = datetime.datetime.now()
		
		#get current day of the week (0=Mon, 1=Tues,...)
		#currDay = datetime.datetime.now().weekday()
		currDay = 0		

		#get current state of the light
		currState = GPIO.input(room2_LED)

		#Check to see if it's time to turn the lights on
		#Will only turn light on if it is off and current time matches
		#programmed time to turn on
		if (currTime.hour - OnTime[currDay].hour==0 and 
			currTime.minute - OnTime[currDay].minute==0 and
			currState ==0):
		
			GPIO.output(room2_LED,GPIO.HIGH)
			
			#Open Database connection
        		db = MySQLdb.connect(servername,username,password,dbname)

       		 	#prepare a cursor object using cursor() method
        		cursor = db.cursor()
			cursor.execute("""INSERT INTO table_for_room2 (date,time,state) VALUES (curdate(),curtime(),%s)""",'on')
			db.commit()
			db.close()
			time.sleep(3)		
			print "Turning on"

		elif(currTime.hour - OffTime[currDay].hour==0 and
                        currTime.minute - OffTime[currDay].minute==0 and
                        currState ==1):
				
			GPIO.output(room2_LED,GPIO.LOW)

			#Open Database connection
                        db = MySQLdb.connect(servername,username,password,dbname)

                        #prepare a cursor object using cursor() method
                        cursor = db.cursor()

			cursor.execute("""INSERT INTO table_for_room2 (date,time,state) VALUES (curdate(),curtime(),%s)""",'off')
                        db.commit()
			db.close()
			time.sleep(3)
			print "Turning off"

time_lights2(sys.argv[1],sys.argv[2])
