# Exercise 1: Laravel API Endpoint & Artisan Command

## Installation Steps

1. **Clone the repository** and navigate to the project root:
   ```bash
   git clone https://github.com/Coreas94/SoftonicProjectJC.git
   cd SoftonicProject
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Ensure the required files are in place:**
   - `outputs/app.json`
   - `outputs/developer.json`

4. **Start the Laravel development server:**
   ```bash
   php artisan serve
   ```

---

## **How to Run the API**
### Fetch app data by ID:
**Endpoint:**  
```http
GET /api/apps/{id}
```
 **Example Request:**
```bash
curl -X GET http://localhost:8000/api/apps/21824
```

 **Example Response:**
```json
{
  "success": true,
  "data": {
    "id": "21824",
    "author_info": {
      "name": "AresGalaxy",
      "url": "https://aresgalaxy.io/"
    },
    "title": "Ares",
    "version": "2.4.0",
    "url": "http://ares.en.softonic.com",
    "short_description": "Fast and unlimited P2P file sharing",
    "license": "Free (GPL)",
    "thumbnail": "https://screenshots.en.sftcdn.net/en/scrn/21000/21824/ares-14-100x100.png",
    "rating": 8,
    "total_downloads": "4741260",
    "compatible": "Windows 2000|Windows XP|Windows Vista|Windows 7|Windows 8"
  }
}
```

---

## **How to Run the Artisan Command**
Retrieve app data using the command line.

 **Example:**
```bash
php artisan app:fetch 21824
```

 **Expected Output:**
```json
{
  "id": "21824",
  "author_info": {
    "name": "AresGalaxy",
    "url": "https://aresgalaxy.io/"
  },
  "title": "Ares",
  "version": "2.4.0",
  "url": "http://ares.en.softonic.com",
  "short_description": "Fast and unlimited P2P file sharing",
  "license": "Free (GPL)",
  "thumbnail": "https://screenshots.en.sftcdn.net/en/scrn/21000/21824/ares-14-100x100.png",
  "rating": 8,
  "total_downloads": "4741260",
  "compatible": "Windows 2000|Windows XP|Windows Vista|Windows 7|Windows 8"
}
```

---

## **How to Run Tests**
Run all tests:
```bash
php artisan test
```
Run a specific test:
```bash
php artisan test --filter=ApiControllerTest
```

---

## **What Would I Improve?**
1️⃣ **Code Structure & Maintainability**  
- I would **extract business logic into a service** (`AppService`) to keep the controller and command clean.  
- Using **DTOs (Data Transfer Objects)** to handle structured responses efficiently.  

2️⃣ **Documentation**  
- I always like to document my code properly, so adding more **docblocks** and API documentation (e.g., OpenAPI/Swagger) would be a great improvement.  

---

## **What Would I Have Done Differently with More Time?**
1️⃣ **Use Laravel Services**  
- I would have created an **`AppService`** to centralize the logic used by both the controller and the command.  
- This would allow for better maintainability and easier scalability.

2️⃣ **Requests & Resources for Better Data Handling**  
- I would have leveraged **Laravel Data (Spatie Laravel Data)** to create structured DTOs, improving type safety, reducing boilerplate code, and making API responses more maintainable and well-documented.

3️⃣ **Better API Documentation**  
- Using **Swagger/OpenAPI** to generate API documentation would improve clarity for future developers and consumers of this API.
