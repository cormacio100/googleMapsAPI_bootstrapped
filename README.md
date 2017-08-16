# Mobile Coverage Fault Report app

##	Overview
### What is this app for?
This app is intended to be used by members of the Customer Care Team and the Field Engineers of a Mobile Phone Company. 

### How Does it work?
Using Google Maps, this app allows for reporting of issues as well as some troubleshooting. It ensures the user asks the customer for relevant information when they are reporting issues with their mobile Coverage. All faults are linked to an email address. The reason for this is that a fault may relate to multiple phone numbers owned by the same customer. So, the user must first ask for an email address whereby all previously reported faults for the user, if any, will be displayed. This allows the user to keep track of ongoing issues as well as report new ones.
Since there is a refresh of the markers on the app, it allows the user to see what mobile sites are currently on or off near the reported fault. This can lead to faster troubleshooting 

### Also

This tool is also intended to allow Field Engineers to keep track of faults that have been reported to them or their regional team. They can add updates and change the status of faults.
They can also, reset sites by turning them on and off. This sometimes fixes the problem. Also, as in a real network, mobile sites are daisy-chained on the network so switching off/on one important site may also turn off/onn multiple connected sites

## Features

### Existing Features
- Home page with a brief explanation of the application as well as how a Mobile Network operates
- Customere Care Section - Report a Fault: Customer Care User enters customer email address here and proceeds to visuals of outages and reported faults. They can then create a new fault or find updates on an existing one. **ALL MARKERS ARE CLICKABLE** for more information
- Field Engineers section:  Can log in and select relevant regional team to view relevant faults reported to them. (Default login displayed on app). Can then update faults and change their status. Users can also administer sites by reseting them as part of troubleshooting

### Features left to Implement
-	Sites "off air" script not yet linked to a live network

## Tech Used
-	[**WAMP version 3.0.4 32bit**](http://www.wampserver.com/en/download-wampserver-32bits/)
-	[**PHP Mini-Framework called Epiphany**](https://github.com/jmathai/epiphany)
-	**MySQL**
-	**Javascript**
-	**CSS**
-	[**Google Maps Javascript API**](https://developers.google.com/maps/documentation/javascript/)
-	[**Bootstrap 2**](http://getbootstrap.com/2.3.2/)

## Contributing

### Getting the code up and running
1. Firstly you will need to have WAMP installed
2. Then you will need to clone this repository into the root folder of WAMP (C:/wamp/www on windows) by running the ''' git clone <project's GITHUB URL>
3. Then run WAMP and in your browser open localhost/phpmyadmin. (Login will usually either be root/<blank> or root/root)
4. Create a database called googlemaps.
5. In this new database you will then import the file db/googlemaps.sql
6. In your browser open localhost/<foldername>, where <foldername> is the folder containing the project

### Default Login for Field Engineers
-	Username: AA
-	Password: password1

##	The Author
Get in touch with the author if you have suggestions or questions.





