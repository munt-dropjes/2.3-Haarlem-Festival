# **Haarlem Festival**

Hi, just a project made for a school project. 

### **Installation**
1. **Clone Repository:**
    ```bash
        git clone https://github.com/munt-dropjes/2.3-Haarlem-Festival
    ```

2. **Start Development Environment:** From the project's root directory, execute in terminal:
    ```bash
        docker compose up
    ```

### **Accessing the application:**
* **The Website:** Visit `http://localhost` in your web browser.

### **Passwords and accounts:**
**_Important Note:_** The following table is for demonstration purposes only.

| Role           | Username (Placeholder) | Password (Placeholder) |
|----------------|------------------------|------------------------|
| Administrator  | `admin@admin.com`      | `      `               |
| ContentManager | `content@content.com`  | `      `               |  
| User           | `user@user.com`        | `      `               |

### **Importing the SQL Script (If necessary):**

Docker Compose might not automatically import the SQL script. If that's the case, follow these steps using PHPMyAdmin:

1. Log in to PHPMyAdmin (`http://localhost:8080`).
2. Select the database.
3. Click the "Import" tab.
4. Browse to the SQL script file located in the `sql` directory (if it exists).
5. Click "Go" to import the script.

### **Stopping the Development Environment:**

* To stop the containers quietly:
    ```bash
        docker compose down
    ```
