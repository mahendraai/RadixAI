# RadixAI
# Copy Right by Mahendra Ribadiya founder of www.heymate.in this is MVP 
1. File Upload Form

Create a form to allow users to upload medical images.

2. Handle Image Upload (upload.php)

Process the uploaded image, store it in a folder, and save the URL in the database.

Database table scheme :

CREATE TABLE medical_images (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    report TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

4. Model Processing

    Once the image is uploaded, it is sent to a Medical Imaging LLM or Computer Vision model (e.g., using a REST API).
    The processMedicalImage() function sends the image URL to the external model.
    The model processes the image, detects abnormalities, and returns a report, which is then saved in the database.

   5. Displaying the Report

Once the report is generated and saved, it can be displayed to the user by querying the database for the report linked to the image.
