<?php
//admin
//verify user
//admindashboard


//user
// set status to paid (sales purchase type)

//admin
//check and modify stores
//send payment notification
//backup files

//vendor
//add window if new
todo
remove vendor files then add to gitignore
admin dashboard (charts)
admin changepassword, changes to user sidenav
admin slider, checked include checkbox	
https://themes.getbootstrap.com/preview/?theme_id=19799
https://themes.getbootstrap.com/preview/?theme_id=35287
remove input ng qty


round 3



REMOVE ADDED JS files





STRIPE ACCOUNT
https://dashboard.stripe.com/test/apikeys

sadiwajordan1991@gmail.com
Cyborg99912@


VISA TESTING
https://stripe.com/docs/testing




composer require league/omnipay omnipay/stripe



admin backupdata







suggest edit/logic error
* product>edit product> dapat i allow yung add ng material kahit out of stock pa yun kasi sa sales>production naman chinecheck yung stock ng material
* productInventory , remove edit qty, remove expiration date( kasi iba iba yung expiration ng products na ginawa, monitoring lang ng qty dapat dito)
* nag add ako ng price sa sales>production, since iba iba yung price kada magpoproduce ng bago





STRIPE ACCOUNT
https://dashboard.stripe.com/test/apikeys

sadiwajordan1991@gmail.com
Cyborg99912@



todo
add edit business profile
upload profile picture
admin dashboard
business profile 
slideshow
free trial logic




done
supplier add new sa all supplier
materials/product same
purchase order - raw material inventory -view - change labels
sales/ bawas sa pinakalumang batch ng production
(applied nadin sa purchase order)
product>add new>sabay na materials
production>rejects
edit material qty (auto update inventory)
production/purchase order before expiration date
purchase order, after submit, view material inventory (sa all material ko ni redirect)
purchase order > static unit
sales/purchaseorder/production, show current stock of selected product
(sa sale lang yung nagbabawas ng current quantity, d na needed sa material and production)
purchase order >conversion (ml,g,pcs) (inalis ko na yung unit sa materials>add new since static na naman to)
products expired products

store>dashboard monthly production vs sales
product/material qty edit
unit sa add product ingredients

check
add ng product kahit wala pang naset na material
if kaya edit history
check if idelete yung material na gamit ng active product
if inedit yung expiry, i reset yung lahat ng deducted value or i reset lahat then recheck
add new material, dapat wala na unit since static na naman














admin>verify user>prompt password
unverify=suspend(status=suspended)
production>batchnumber = currentdate + batchnumber (01202012)
production>dateproduced  set default ddate (current)
production>dateproduced future date(add sa expiry opposite)

materials>prioritize expire date
production>add materials(modal)
production> add reject sa right table
rejects >deduct(add sa all product)
products>expired products>add button 'use as material' 2 days expiry (d na pde mause as material after expiry)
sales>expenses remove
reports>expenses>materials expenses
reports>raw materials>credit date = due date
reports>raw materials>add new column 'status:paid,unpaid,overdue', value 'days', change color
if changed to cash, paid,...










