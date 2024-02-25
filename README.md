
At first you should run this command to generate all API documentation:
php artisan l5-swagger:generate

For testing Transaction API you could use the below link: 

http://YourSiteDomain/api/documentation/


**General description of the project:**
This is one of the APIs of a banking system. developed using the latest Laravel framework version with the following conditions:

**Project Assumptions:**
- Each user in the system can have one mobile number and several account numbers and several card numbers for each account number.
- In all cases, I've used similar items. For example, if I need an API KEY from a service, I complete it with a default value.
  
**Requirement:**
- There is an API that takes the source and target card number and performs the transfer operation if the balance is sufficient.
- The card number will be Validate and only one valid card number. Therefore, The system will not accept card numbers that are not valid in Iran's banking system, for example, 1234-1234-1234-1234 is invalid.
- The minimum amount to do is 1000 Tomans and the maximum amount is 50 million Tomans.
- Each transaction incurs a fee of 500 Tomans for your bank, and there is a table of these fees.
- This API has the ability to process the card number and amount with English, Farsi and Arabic numbers, and you should not make the client send the numbers in English.
- After completing this transaction, both the source and target users will be sent an SMS to reduce/increase the available amount.
- The system is able to send SMS from Kavenegar SMS service companies

** The API is developed in REST.
