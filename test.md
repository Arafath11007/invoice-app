Please complete the task detailed below. Your selection for the role will be based on this task completion within the time period mentioned below the task.
ASSIGNMENT:

1. Install fresh Laravel 9
2. Enable laravel authentication (Breeze Package)
3. Invoice

   1. Qty (Only numeric characters)
   2. Amount (Only numeric characters)
   3. Total Amount (qty \* amount)
   4. Tax Amount
   5. Net Amount (total amount + tax amount)
   6. Name (Only alpha characters)
   7. Date (datepikcer plugin)
   8. File Upload (Max 3 MB file only support JPG, PNG, PDF)

Note: 6,7,8 need to be saved as table invoice and 1,2,3,4,5 columns need to be saved in invoice_sub table. The invoice id should be there as a foreign key.
Note: Above validation should be done both from the client-side (Using the Jquery plugin or manual) and server-side (Laravel Request Validation)

4. Multiple rows can be added by clicking add row button
5. Save/edit/delete option needs to be done through ajax.
6. All invoices need to come as a table list and each row has two buttons Edit and Delete. If delete is pressed needs to be deleted through ajax and the row needs to be removed without page refresh.
7. For the table list Laravel Datatable plugin needs to be used for both jQuery and Laravel
8. In the user table there is a column that should be a role
   0 - Admin (If the user logged as a user he/she can see invoices only created by him/her)
   1 - User (If the user logged as a user he/she can see invoices only created by him/her)
9. For point 8 works must need more than three users and each user must have invoices

Important Note:

1. Task validity one day
2. Once the task is done laravel source code (Except the vendor folder) needs to be sent as a zip file.
3. Database also needs to be attached along with the email.
