### How to Run

**Database Setup:**
   * Create a new database in MySQL ```ticket_db```
   * Update your credentials in `config/app_local.php`.
     
**Run Migrations:**

  * `bin/cake migrations migrate`
   
**Start Server:**
   * `bin/cake server`



# Support Ticketing System

## Project Description
Develop a simple internal system that allows users to create, manage, and track support tickets. Each ticket represents a request or issue submitted by a user. The system should allow viewing tickets, updating their status, adding internal notes, and uploading attachments related to tickets.

---

## Functional Requirements

### 1. Authentication
The system must include a basic login system. Users must:
* Login to access the system.
* Logout from the system.
* Authentication should be implemented using CakePHP authentication mechanisms.
* Passwords must be stored hashed.
* Unauthenticated users should not be able to access ticket pages.

### 2. Ticket Management
The system should allow the following operations:

#### List Tickets
Create a page that displays all tickets in a table. The table should include:
* ID, Subject, Customer Name, Priority, Status, Created Date.
* Actions (View, Edit, Delete).
* **The list page should include:** Pagination, Search by subject or customer name, Filter by status, Filter by priority.

#### Add Ticket
Create a form to add a new ticket with the following fields:
* Subject, Customer Name, Customer Email, Message / Description, Priority, Status, Attachment (file upload).

#### File Upload
Allow users to upload a file attachment when creating a ticket.
* **Allowed file types:** jpg, png, pdf, doc, docx.
* **Maximum file size:** 2MB.
* **Storage path:** `webroot/uploads/tickets/`.
* Store the file name or path in the database.

#### Edit Ticket
* Allow editing an existing ticket and updating its information.
* Users should also be able to replace the uploaded attachment.

#### View Ticket Details
Create a page that displays the full ticket information including:
* Subject, Customer Name, Customer Email, Message, Priority, Status, Attachment (download link), Created date.
* This page should also show all notes/comments related to the ticket.

#### Delete Ticket
* Allow deleting a ticket from the system.
* Before deletion, display a confirmation message using JavaScript or jQuery.

#### Change Ticket Status
Provide a way to change the ticket status (Open, In Progress, Closed). This can be done through:
* An action button in the ticket list OR from the ticket details page.

### 3. Ticket Notes / Comments
Each ticket should allow adding internal notes/comments.
* **Each note should contain:** Note text and Created date.
* **On the ticket details page:** Display a list of existing notes and include a form to add a new note.
* *This requirement is intended to practice CakePHP associations.*

### 4. AJAX Feature
* Implement a simple AJAX request to add a note without refreshing the page.
* Use jQuery AJAX for this functionality.

### 5. CAPTCHA
* Add Google reCAPTCHA V3 or any other captcha to the Add Ticket form.
* Validate the CAPTCHA response on the server before saving the ticket.

---

## CakePHP Requirements
Your implementation must demonstrate the use of the following CakePHP features:

* **MVC Structure:** Proper use of Controllers, Models (Table and Entity), and Views (Templates).
* **ORM Usage:** Using CakePHP ORM for CRUD operations and loading related data using `contain()`.
* **Associations:** Implement relationship (A Ticket `hasMany` Notes / A Note `belongsTo` Ticket).
* **Validation:** * **Tickets:** Subject, Customer name, Customer email (valid format), Message, Priority, and Status are required.
    * **Notes:** Note text is required.
* **Pagination:** Use CakePHP pagination on the tickets list page.
* **Search and Filtering:** Implement search for Subject/Customer name and filters for Status/Priority.
* **Flash Messages:** Display success or error messages after all major operations.
* **Helpers:** Use `FormHelper`, `HtmlHelper`, and `PaginatorHelper`.

---

## Frontend Requirements
Use basic frontend technologies: **HTML, CSS, JavaScript, jQuery.**

* **Suggested features:**
    * Confirmation dialogue before deleting a ticket.
    * Basic styling for tables and forms.
    * Highlight tickets with **High priority**.
    * Different color for **Closed tickets**.

---

## Bonus Features (Optional)
* Dashboard showing ticket statistics (Open / In Progress / Closed).
* Highlight overdue tickets.
* Export tickets to CSV.
* Drag-and-drop file upload.
* Ticket priority color indicators.
