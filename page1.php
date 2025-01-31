<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save form data into session variables
    $_SESSION['uli_number'] = $_POST['uli_number'];
    $_SESSION['entry_date'] = $_POST['entry_date'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['middle_name'] = $_POST['middle_name'];
    $_SESSION['address_number_street'] = $_POST['address_number_street'];
    $_SESSION['address_barangay'] = $_POST['address_barangay'];
    $_SESSION['address_district'] = $_POST['address_district'];
    $_SESSION['address_city_municipality'] = $_POST['address_city_municipality'];
    $_SESSION['address_province'] = $_POST['address_province'];
    $_SESSION['address_region'] = $_POST['address_region'];
    $_SESSION['email_facebook'] = $_POST['email_facebook'];
    $_SESSION['contact_no'] = $_POST['contact_no'];
    $_SESSION['nationality'] = $_POST['nationality'];

    // Handle file uploads
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $uploadedFile = $_FILES['profile_image'];
        $uploadDir = 'Upload-image/'; // Ensure this directory exists and is writable
        $uploadFile = $uploadDir . basename($uploadedFile['name']);

        // Validate file type
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            exit();
        }

        // Validate file size (limit to 500KB)
        if ($uploadedFile['size'] > 500000) {
            echo 'Sorry, your file is too large.';
            exit();
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($uploadedFile['tmp_name'], $uploadFile)) {
            $_SESSION['profile_image'] = $uploadFile; // Save file path to session
        } else {
            echo 'File upload failed!';
            exit();
        }
    }

    header('Location: page2.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form - Page 1</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f9;
        }

        .page {
            max-width: auto; /* Adjust as needed */
            height: auto;
            margin: 0 auto;
            padding: 60px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden; /* Prevents overflow from breaking layout */
           
        }

        h2, h1, p {
            text-align: center;
            margin-bottom: 10px;
        }

        form {
            width: 100%;
            margin-top: 20px; /* Provides space between headings and form */
        }

        .image-upload-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 2px;
        }

        .image-preview {
            width: 140px;
            height: 120px;
            border: 1px solid #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            margin-top: 10px;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }

        .image-upload-label {
            cursor: pointer;
            height: 0px;
            position: relative;
            top: -30px;
            font-size: 15px;
            text-align: center;
            color: #007bff;
            text-decoration: underline;
        }

        table {
        border-collapse: collapse;
        margin: 0 auto 20px; /* Center the table horizontally */
   
        }
        .tab1{
            width: 1100px;
        }
        .tab2{
          text-align: center;
          width: 1000px;
        }

        th, td {
            padding: 3px; /* Adjust the padding size as needed */
            height: 10px;
            border: 1px solid #007bff;
            font-size: 20px;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td input[type="text"] {
            width: calc(100% - 16px); /* Adjust width to fit table without overflow */
            padding: 6px;
            width: auto;
            border: 1px solid black;
            border-radius: 4px;
            margin-top: 5px;
        }

        .center {
            text-align: center;
            margin-top: 20px; /* Provides space for button */
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
       

        @media (max-width: 768px) {
            .page {
                padding: 20px; /* Adjust padding for smaller screens */
            }

            th, td {
                font-size: 14px;
            }

            button[type="submit"] {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <h1>Technical Education and Skills Development Authority</h1>
        <h1><p>Pangasiwaan sa Edukasyong Teknikal at Pagpapaunlad ng Kasanayan</p></h1>
        <h1>Registration Form - Page 1/4</h1>
        <form action="" method="post" enctype="multipart/form-data">
        <table class="tab1">
                <tr>
                    <th colspan="2" class="learner">LEARNERS PROFILE FORM</th>
                </tr>
                <tr>
                <td> <div class="image-upload-container">
                <div class="image-preview" id="imagePreview">
                    <?php if (isset($_SESSION['profile_image'])): ?>
                        <img src="<?= $_SESSION['profile_image'] ?>" alt="Profile Image">
                    <?php else: ?>
                        <span>I.D Picture</span>
                        <?php endif; ?>
                    </div>
                    <label class="image-upload-label" for="profile_image">Choose Image</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                   </div></td>
                    <td> 1.1. Unique Learner Identifier (ULI) Number:          
                    <input type="text" name="uli_number" placeholder="(ULI) Number" value="<?= isset($_SESSION['uli_number']) ? htmlspecialchars($_SESSION['uli_number']) : '' ?>">
                    Entry Date:
                    <input type="date" name="entry_date" size="10" placeholder="mm-dd-yy" value="<?= isset($_SESSION['entry_date']) ? htmlspecialchars($_SESSION['entry_date']) : '' ?>"><br>
                     2.1. Name:
                        <input type="text" name="last_name" size="15" placeholder="Last Name, Extension Name (Jr., Sr.)" value="<?= isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : '' ?>">
                        <input type="text" name="first_name" size="15" placeholder="First Name" value="<?= isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : '' ?>">
                        <input type="text" name="middle_name" size="15" placeholder="Middle Name" value="<?= isset($_SESSION['middle_name']) ? htmlspecialchars($_SESSION['middle_name']) : '' ?>">
                    </td>
                </tr>
          <tr>
                    <th colspan="2" >2.2. Complete Permanent Mailing Address:</th>
                </tr>
                    
                
                    <tr>
                        <td colspan="2" class="tab2">
                        <select id="address_city_municipality" name="address_city_municipality" onchange="updateBarangays()">
                    <option value="">Select City/Municipality</option>
                    <option value="Arayat">Arayat</option>
                    <option value="AnotherCity">Another City</option>
                    <!-- Add more cities/municipalities as needed -->
                </select>

                <select id="address_barangay" name="address_barangay" onchange="updateStreets()" disabled>
                    <option value="">Select Barangay</option>
                    <!-- Barangay options will be populated dynamically -->
                </select>

                <select id="address_number_street" name="address_number_street" onchange="updateDistricts()" disabled>
                    <option value="">Select Number, Street</option>
                    <!-- Number and Street options will be populated dynamically -->
                </select>
                <select id="address_district" name="address_district" onchange="updateProvinces()" disabled>
                    <option value="">Select District</option>
                    <!-- District options will be populated dynamically -->
                </select>
                <select id="address_province" name="address_province" onchange="updateRegions()" disabled>
                    <option value="">Select Province</option>
                    <!-- Province options will be populated dynamically -->
                </select>
                <select id="address_region" name="address_region" onchange="updateNationalities()" disabled>
                    <option value="">Select Region</option>
                    <!-- Region options will be populated dynamically -->
                </select>
                <select id="nationality" name="nationality" disabled>
                    <option value="">Select Nationality</option>
                    <!-- Nationality options will be populated dynamically -->
                </select><br>
                <input type="text" name="email_facebook" size="20" placeholder="Email Address/Facebook Account" value="<?= isset($_SESSION['email_facebook']) ? htmlspecialchars($_SESSION['email_facebook']) : '' ?>">
                <input type="text" name="contact_no" size="20" placeholder="Contact No" value="<?= isset($_SESSION['contact_no']) ? htmlspecialchars($_SESSION['contact_no']) : '' ?>">
                        </td>


                    </tr>
                
            </td>
                </tr>
            </table>
            <div class="center">
                <button type="submit">Next</button>
            </div>
        </form>
    </div>
    <script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            output.innerHTML = `<img src="${reader.result}" alt="Profile Image">`;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    </script>


<script>
    const data = {
        'Arayat': {
            barangays: [
                'Arenas', 'Baliti', 'Batasan', 'Buensuceso', 'Candating', 'Gatiawin', 
                'Guemasan', 'La Paz (Turu)', 'Lacmit', 'Lacquios', 'Mangga-Cacutud', 
                'Mapalad', 'Panlinlang', 'Paralaya', 'Plazang Luma', 'Poblacion', 
                'San Agustin Norte', 'San Agustin Sur', 'San Antonio', 'San Jose Mesulo', 
                'San Juan Bano', 'San Mateo', 'San Nicolas', 'San Roque Bitas', 
                'Cupang (Santa Lucia)', 'Matamo (Santa Lucia)', 'Santo Niño Tabuan', 
                'Suclayin', 'Telapayong', 'Kaledian (Camba)'
            ],
            streets: ['Street1', 'Street2', 'Street3'], // Replace with actual streets
            districts: ['District1', 'District2', 'District3'], // Replace with actual districts
            provinces: ['Province1', 'Province2', 'Province3'], // Replace with actual provinces
            regions: ['Region1', 'Region2', 'Region3'], // Replace with actual regions
            nationalities: ['Nationality1', 'Nationality2', 'Nationality3'] // Replace with actual nationalities
        },
        'AnotherCity': {
            barangays: ['BarangayA', 'BarangayB', 'BarangayC'],
            streets: ['StreetA', 'StreetB', 'StreetC'], // Replace with actual streets
            districts: ['DistrictA', 'DistrictB', 'DistrictC'], // Replace with actual districts
            provinces: ['ProvinceA', 'ProvinceB', 'ProvinceC'], // Replace with actual provinces
            regions: ['RegionA', 'RegionB', 'RegionC'], // Replace with actual regions
            nationalities: ['NationalityA', 'NationalityB', 'NationalityC'] // Replace with actual nationalities
        }
        // Add more cities/municipalities and their corresponding data as needed
    };

    function updateBarangays() {
        const citySelect = document.getElementById('address_city_municipality');
        const barangaySelect = document.getElementById('address_barangay');
        const selectedCity = citySelect.value;

        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        document.getElementById('address_number_street').innerHTML = '<option value="">Select Number, Street</option>';
        document.getElementById('address_district').innerHTML = '<option value="">Select District</option>';
        document.getElementById('address_province').innerHTML = '<option value="">Select Province</option>';
        document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
        document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

        document.getElementById('address_barangay').disabled = true;
        document.getElementById('address_number_street').disabled = true;
        document.getElementById('address_district').disabled = true;
        document.getElementById('address_province').disabled = true;
        document.getElementById('address_region').disabled = true;
        document.getElementById('nationality').disabled = true;

        if (selectedCity && data[selectedCity]) {
            barangaySelect.disabled = false;
            data[selectedCity].barangays.forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay;
                option.textContent = barangay;
                barangaySelect.appendChild(option);
            });
        }
    }

    function updateStreets() {
        const barangaySelect = document.getElementById('address_barangay');
        const streetSelect = document.getElementById('address_number_street');
        const selectedBarangay = barangaySelect.value;

        streetSelect.innerHTML = '<option value="">Select Number, Street</option>';
        document.getElementById('address_district').innerHTML = '<option value="">Select District</option>';
        document.getElementById('address_province').innerHTML = '<option value="">Select Province</option>';
        document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
        document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

        document.getElementById('address_number_street').disabled = true;
        document.getElementById('address_district').disabled = true;
        document.getElementById('address_province').disabled = true;
        document.getElementById('address_region').disabled = true;
        document.getElementById('nationality').disabled = true;

        if (selectedBarangay) {
            streetSelect.disabled = false;
            data['Arayat'].streets.forEach(street => {
                const option = document.createElement('option');
                option.value = street;
                option.textContent = street;
                streetSelect.appendChild(option);
            });
        }
    }

    function updateDistricts() {
        const streetSelect = document.getElementById('address_number_street');
        const districtSelect = document.getElementById('address_district');
        const selectedStreet = streetSelect.value;

        districtSelect.innerHTML = '<option value="">Select District</option>';
        document.getElementById('address_province').innerHTML = '<option value="">Select Province</option>';
        document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
        document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

        document.getElementById('address_district').disabled = true;
        document.getElementById('address_province').disabled = true;
        document.getElementById('address_region').disabled = true;
        document.getElementById('nationality').disabled = true;

        if (selectedStreet) {
            districtSelect.disabled = false;
            data['Arayat'].districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    }

    function updateProvinces() {
        const districtSelect = document.getElementById('address_district');
        const provinceSelect = document.getElementById('address_province');
        const selectedDistrict = districtSelect.value;

        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
        document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

        document.getElementById('address_province').disabled = true;
        document.getElementById('address_region').disabled = true;
        document.getElementById('nationality').disabled = true;

        if (selectedDistrict) {
            provinceSelect.disabled = false;
            data['Arayat'].provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province;
                option.textContent = province;
                provinceSelect.appendChild(option);
            });
        }
    }

    function updateRegions() {
        const provinceSelect = document.getElementById('address_province');
        const regionSelect = document.getElementById('address_region');
        const selectedProvince = provinceSelect.value;

        regionSelect.innerHTML = '<option value="">Select Region</option>';
        document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

        document.getElementById('address_region').disabled = true;
        document.getElementById('nationality').disabled = true;

        if (selectedProvince) {
            regionSelect.disabled = false;
            data['Arayat'].regions.forEach(region => {
                const option = document.createElement('option');
                option.value = region;
                option.textContent = region;
                regionSelect.appendChild(option);
            });
        }
    }

    function updateNationalities() {
        const regionSelect = document.getElementById('address_region');
        const nationalitySelect = document.getElementById('nationality');
        const selectedRegion = regionSelect.value;

        nationalitySelect.innerHTML = '<option value="">Select Nationality</option>';

        document.getElementById('nationality').disabled = true;

        if (selectedRegion) {
            nationalitySelect.disabled = false;
            data['Arayat'].nationalities.forEach(nationality => {
                const option = document.createElement('option');
                option.value = nationality;
                option.textContent = nationality;
                nationalitySelect.appendChild(option);
            });
        }
    }
</script>



</body>
</html>
