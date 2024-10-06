<?php
//Developed by Mahendra Ribadiya founder of www.heymate.in - AI development company #heymate
$targetDir = "uploads/";
$imageFile = $targetDir . basename($_FILES["medical_image"]["name"]);
$imageFileType = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));

// Check if image file is a valid image type (you can add more validations)
//Developed by Mahendra Ribadiya founder of www.heymate.in - AI development company #heymate
if (move_uploaded_file($_FILES["medical_image"]["tmp_name"], $imageFile)) {
    // Save the image URL in the database
    $imageUrl = $imageFile;
    
    // Database connection
    $servername = "localhost";
    $username = "xray1";
    $password = "123456";
    $dbname = "xray";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Insert image URL into database
    $sql = "INSERT INTO medical_images (image_url) VALUES ('$imageUrl')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Image uploaded successfully.";
        // Call function to process the image
        processMedicalImage($imageUrl);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
} else {
    echo "Sorry, there was an error uploading your file.";
}

// Function to send image to LLM or CV model for report generation
function processMedicalImage($imageUrl) {
    // Placeholder for sending image to external model (LLM or Computer Vision API)
  function processMedicalImage($imageUrl) {
    // Hugging Face API URL for a medical imaging model (example for lung X-ray analysis)
    $apiUrl = "https://api-inference.huggingface.co/models/microsoft/biogpt-medical-imaging";
    
    // Your Hugging Face API token
    $apiToken = "your-hugging-face-api-token";

    // Prepare the data
    $data = json_encode(['inputs' => ['image_url' => $imageUrl]]);
    
    // Set up cURL to send the request to the Hugging Face model API
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiToken",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    // Execute the request
    $result = curl_exec($ch);
    
    // Error handling
    if ($result === FALSE) {
        die('Error: ' . curl_error($ch));
    }
    
    curl_close($ch);
    
    // Assuming the response contains a report
    $generatedReport = json_decode($result, true)['report'];

    // Save the report in the database
    saveReport($generatedReport, $imageUrl);
}


   // You can use CURL or file_get_contents for HTTP POST requests
    $data = array('image_url' => $imageUrl);

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    
    $context  = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);
    
    if ($result === FALSE) {
        /* Handle error */
        echo "Error processing image.";
    }
    
    // Assuming $result contains the generated report
    $generatedReport = json_decode($result, true)['report'];
    
    // Save the generated report to the database
    saveReport($generatedReport, $imageUrl);
}

// Function to save the generated report into the database
function saveReport($report, $imageUrl) {
    // Database connection
    $servername = "localhost";
    $username = "xray1";
    $password = "123456";
    $dbname = "xray";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Update the report for the corresponding image
    $sql = "UPDATE medical_images SET report = '$report' WHERE image_url = '$imageUrl'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Report generated and saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>//Developed by Mahendra Ribadiya founder of www.heymate.in - AI development company #heymate
