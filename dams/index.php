<?php
session_start();
//error_reporting(0);
include('doctor/includes/dbconnection.php');
    if(isset($_POST['submit']))
  {
 $name=$_POST['name'];
  $mobnum=$_POST['phone'];
 $email=$_POST['email'];
 $appdate=$_POST['date'];
 $aaptime=$_POST['time'];
 $specialization=$_POST['specialization'];
  $doctorlist=$_POST['doctorlist'];
 $message=$_POST['message'];
 $aptnumber=mt_rand(100000000, 999999999);
 $cdate=date('Y-m-d');

if($appdate<=$cdate){
       echo '<script>alert("Appointment date must be greater than todays date")</script>';
} else {
$sql="insert into tblappointment(AppointmentNumber,Name,MobileNumber,Email,AppointmentDate,AppointmentTime,Specialization,Doctor,Message)values(:aptnumber,:name,:mobnum,:email,:appdate,:aaptime,:specialization,:doctorlist,:message)";
$query=$dbh->prepare($sql);
$query->bindParam(':aptnumber',$aptnumber,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':appdate',$appdate,PDO::PARAM_STR);
$query->bindParam(':aaptime',$aaptime,PDO::PARAM_STR);
$query->bindParam(':specialization',$specialization,PDO::PARAM_STR);
$query->bindParam(':doctorlist',$doctorlist,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);

 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Your Appointment Request Has Been Send. We Will Contact You Soon")</script>';
echo "<script>window.location.href ='index.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Doctor Appointment Management System || Home Page</title>
        
        <!-- Performance Optimizations -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- Resource Hints for Faster Loading -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="dns-prefetch" href="//fonts.googleapis.com">
        
        <!-- Preload Critical Resources -->
        <link rel="preload" href="css/bootstrap.min.css" as="style">
        <link rel="preload" href="css/templatemo-medic-care.css" as="style">
        <link rel="preload" href="js/bootstrap.bundle.min.js" as="script">

        <!-- CSS FILES -->        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/owl.carousel.min.css" rel="stylesheet">
        <link href="css/owl.theme.default.min.css" rel="stylesheet">
        <link href="css/templatemo-medic-care.css" rel="stylesheet">
        
        <!-- Loading Indicator -->
        <style>
            .loading {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255,255,255,0.9);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                transition: opacity 0.3s;
            }
            .loading.hidden {
                opacity: 0;
                pointer-events: none;
            }
            .spinner {
                width: 40px;
                height: 40px;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #007bff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
        
        <script>
        // Enhanced AJAX with loading states and error handling
        function getdoctors(val) {
            if (!val) {
                $("#doctorlist").html('<option value="">Select Doctor</option>');
                return;
            }
            
            // Show loading state
            $("#doctorlist").html('<option value="">Loading doctors...</option>');
            
            $.ajax({
                type: "POST",
                url: "get_doctors.php",
                data: 'sp_id=' + val,
                timeout: 10000, // 10 second timeout
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let options = '<option value="">Select Doctor</option>';
                        if (response.doctors && response.doctors.length > 0) {
                            response.doctors.forEach(function(doctor) {
                                options += '<option value="' + doctor.id + '">' + doctor.name + '</option>';
                            });
                        } else {
                            options = '<option value="">No doctors available for this specialization</option>';
                        }
                        $("#doctorlist").html(options);
                    } else {
                        $("#doctorlist").html('<option value="">Error: ' + (response.error || 'Unable to load doctors') + '</option>');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Error loading doctors. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    $("#doctorlist").html('<option value="">' + errorMessage + '</option>');
                    console.error("AJAX Error:", error);
                }
            });
        }

        // Get doctors for modal form
        function getdoctorsModal(val) {
            if (!val) {
                $("#modal-doctorlist").html('<option value="">Select Doctor</option>');
                return;
            }
            
            // Show loading state
            $("#modal-doctorlist").html('<option value="">Loading doctors...</option>');
            
            $.ajax({
                type: "POST",
                url: "get_doctors.php",
                data: 'sp_id=' + val,
                timeout: 10000, // 10 second timeout
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let options = '<option value="">Select Doctor</option>';
                        if (response.doctors && response.doctors.length > 0) {
                            response.doctors.forEach(function(doctor) {
                                options += '<option value="' + doctor.id + '">' + doctor.name + '</option>';
                            });
                        } else {
                            options = '<option value="">No doctors available for this specialization</option>';
                        }
                        $("#modal-doctorlist").html(options);
                    } else {
                        $("#modal-doctorlist").html('<option value="">Error: ' + (response.error || 'Unable to load doctors') + '</option>');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Error loading doctors. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    $("#modal-doctorlist").html('<option value="">' + errorMessage + '</option>');
                    console.error("AJAX Error:", error);
                }
            });
        }
        

        

        
        // Page load optimizations
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading screen
            const loading = document.querySelector('.loading');
            if (loading) {
                setTimeout(() => {
                    loading.classList.add('hidden');
                    setTimeout(() => loading.remove(), 300);
                }, 500);
            }
 

            
            // Debug image loading for reviews
            const reviewImages = document.querySelectorAll('.reviewer-avatar img');
            reviewImages.forEach((img, index) => {
                img.addEventListener('load', function() {
                    console.log(`Review image ${index + 1} loaded successfully:`, this.src);
                });
                
                img.addEventListener('error', function() {
                    console.error(`Review image ${index + 1} failed to load:`, this.src);
                    // Hide the image and show fallback
                    this.style.display = 'none';
                    const fallback = this.nextElementSibling;
                    if (fallback && fallback.classList.contains('avatar-fallback')) {
                        fallback.style.display = 'flex';
                    }
                });
            });
        });
        
        // Individual field validation
        function validateField(field) {
            const fieldId = field.id;
            const value = field.value.trim();
            
            clearFieldError(fieldId);
            
            switch(fieldId) {
                case 'name':
                    if (value.length < 2) {
                        showError(fieldId, 'Name must be at least 2 characters long');
                    }
                    break;
                case 'email':
                    const emailRegex = /^[^\s@]+@[^-\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        showError(fieldId, 'Please enter a valid email address');
                    }
                    break;
                case 'phone':
                    const phoneRegex = /^\d{10}$/;
                    if (!phoneRegex.test(value)) {
                        showError(fieldId, 'Please enter a valid 10-digit phone number');
                    }
                    break;
                case 'date':
                    const today = new Date().toISOString().split('T')[0];
                    if (value <= today) {
                        showError(fieldId, 'Appointment date must be in the future');
                    }
                    break;
                case 'time':
                    if (!value) {
                        showError(fieldId, 'Please select appointment time');
                    }
                    break;
                case 'specialization':
                    if (!value) {
                        showError(fieldId, 'Please select specialization');
                    }
                    break;
                case 'doctorlist':
                    if (!value) {
                        showError(fieldId, 'Please select a doctor');
                    }
                    break;
            }
        }
        
        function clearFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.remove('is-invalid');
                const errorDiv = field.parentNode.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        }

        // Modal form initialization
        const modalForm = document.getElementById('modalAppointmentForm');
        const modalProgressBar = document.getElementById('modalFormProgress');
        
        if (modalForm && modalProgressBar) {
            const modalFormFields = modalForm.querySelectorAll('input, select, textarea');
            
            // Modal form progress tracking
            function updateModalProgress() {
                let filledFields = 0;
                modalFormFields.forEach(field => {
                    if (field.value.trim() !== '' && field.type !== 'submit') {
                        filledFields++;
                    }
                });
                const progress = (filledFields / modalFormFields.length) * 100;
                modalProgressBar.style.width = progress + '%';
                modalProgressBar.setAttribute('aria-valuenow', progress);
            }
            
            // Update modal progress on field changes
            modalFormFields.forEach(field => {
                field.addEventListener('input', updateModalProgress);
                field.addEventListener('change', updateModalProgress);
            });
            
            // Modal form submission
            modalForm.addEventListener('submit', function(e) {
                if (!validateModalForm()) {
                    e.preventDefault();
                    // Scroll to first error in modal
                    const firstError = modalForm.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    // Show loading state
                    const submitBtn = document.getElementById('modal-submit-button');
                    const btnText = submitBtn.querySelector('.btn-text');
                    const btnLoading = submitBtn.querySelector('.btn-loading');
                    
                    btnText.classList.add('d-none');
                    btnLoading.classList.remove('d-none');
                    submitBtn.disabled = true;
                    
                    // Re-enable after 3 seconds if form doesn't submit
                    setTimeout(() => {
                        btnText.classList.remove('d-none');
                        btnLoading.classList.add('d-none');
                        submitBtn.disabled = false;
                    }, 3000);
                }
            });
        }

        // Modal form validation
        function validateModalForm() {
            const name = document.getElementById('modal-name').value.trim();
            const email = document.getElementById('modal-email').value.trim();
            const phone = document.getElementById('modal-phone').value.trim();
            const date = document.getElementById('modal-date').value;
            const time = document.getElementById('modal-time').value;
            const specialization = document.getElementById('modal-specialization').value;
            const doctorlist = document.getElementById('modal-doctorlist').value;
            
            // Clear previous error messages
            clearModalErrors();
            
            let isValid = true;
            
            // Name validation
            if (name.length < 2) {
                showModalError('modal-name', 'Name must be at least 2 characters long');
                isValid = false;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showModalError('modal-email', 'Please enter a valid email address');
                isValid = false;
            }
            
            // Phone validation
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phone)) {
                showModalError('modal-phone', 'Please enter a valid 10-digit phone number');
                isValid = false;
            }
            
            // Date validation
            const today = new Date().toISOString().split('T')[0];
            if (date <= today) {
                showModalError('modal-date', 'Appointment date must be in the future');
                isValid = false;
            }
            
            // Time validation
            if (!time) {
                showModalError('modal-time', 'Please select appointment time');
                isValid = false;
            }
            
            // Specialization validation
            if (!specialization) {
                showModalError('modal-specialization', 'Please select specialization');
                isValid = false;
            }
            
            // Doctor validation
            if (!doctorlist) {
                showModalError('modal-doctorlist', 'Please select a doctor');
                isValid = false;
            }
            
            return isValid;
        }
        
        function showModalError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-danger small mt-1';
            errorDiv.textContent = message;
            field.parentNode.appendChild(errorDiv);
            field.classList.add('is-invalid');
        }
        
        function clearModalErrors() {
            const modalForm = document.getElementById('modalAppointmentForm');
            modalForm.querySelectorAll('.error-message').forEach(el => el.remove());
            modalForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        }

        // Initialize modal date and time when modal opens
        document.getElementById('bookingModal').addEventListener('shown.bs.modal', function () {
            // Set minimum date and time for modal form
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            const modalDateInput = document.getElementById('modal-date');
            const modalTimeInput = document.getElementById('modal-time');
            
            if (modalDateInput) {
                modalDateInput.min = tomorrow.toISOString().split('T')[0];
                modalDateInput.value = tomorrow.toISOString().split('T')[0];
            }
            
            if (modalTimeInput) {
                modalTimeInput.value = '09:00';
            }
            
            // Focus on first input
            const firstInput = modalForm.querySelector('input[type="text"]');
            if (firstInput) {
                firstInput.focus();
            }
        });

        // Clear modal form when modal is hidden
        document.getElementById('bookingModal').addEventListener('hidden.bs.modal', function () {
            const modalForm = document.getElementById('modalAppointmentForm');
            modalForm.reset();
            clearModalErrors();
            
            // Reset progress bar
            const modalProgressBar = document.getElementById('modalFormProgress');
            if (modalProgressBar) {
                modalProgressBar.style.width = '0%';
                modalProgressBar.setAttribute('aria-valuenow', 0);
            }
        });
        </script>
    </head>
    
    <body id="top">
        <!-- Loading Screen -->
        <div class="loading">
            <div class="spinner"></div>
        </div>
    
        <main>

            <?php include_once('includes/header.php');?>

            <section class="hero user-hero-section d-flex align-items-center justify-content-center" id="hero" style="min-height: 80vh; background: linear-gradient(120deg, #e0eaff 0%, #f8fbff 100%); position: relative;">
                <div class="container position-relative" style="z-index: 2;">
                    <div class="row align-items-center justify-content-center">
                        <!-- Left: Welcome Text -->
                        <div class="col-lg-6 col-md-12 text-lg-start text-center mb-4 mb-lg-0">
                            <h1 class="display-4 fw-bold mb-4" style="color: var(--primary-color); letter-spacing: 1px; line-height: 1.2;">Welcome to Doctor Appointment Management System</h1>
                            <p class="lead mb-5" style="color: #333; font-size: 1.3rem; line-height: 1.6;">Book your appointment with our experienced doctors in just a few clicks. Fast, easy, and secure healthcare access for everyone.</p>
                        </div>
                        <!-- Right: Image Slider -->
                        <div class="col-lg-6 col-md-10 mx-auto d-flex justify-content-lg-end justify-content-center">
                            <div id="homeSlider" class="carousel slide mb-4 w-100" data-bs-ride="carousel" data-bs-interval="3000" style="max-width: 500px; margin:auto;">
                                <div class="carousel-inner rounded-4 shadow" style="height:400px;">
                                    <div class="carousel-item active">
                                        <img src="images/slider/doctor-s-hand-holding-stethoscope-closeup.jpg" class="d-block w-100 h-100" style="width:100%;height:400px;object-fit:cover;" alt="Doctor holding stethoscope">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="images/slider/portrait-successful-mid-adult-doctor-with-crossed-arms.jpg" class="d-block w-100 h-100" style="width:100%;height:400px;object-fit:cover;" alt="Mid adult doctor portrait">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="images/slider/young-asian-female-dentist-white-coat-posing-clinic-equipment.jpg" class="d-block w-100 h-100" style="width:100%;height:400px;object-fit:cover;" alt="Female dentist posing">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#homeSlider" data-bs-slide="prev" style="filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3));">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden" style="color: yellow;"><</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#homeSlider" data-bs-slide="next" style="filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3));">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden" style="color: yellow;">></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-hero-overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(255,255,255,0.7); z-index: 1;"></div>
            </section>

            <section class="section-padding" id="about">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-12">
                            <?php
$sql="SELECT * from tblpage where PageType='aboutus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                            <h2 class="mb-lg-3 mb-3"><?php  echo htmlentities($row->PageTitle);?></h2>

                            <p><?php  echo ($row->PageDescription);?>.</p>

                           <?php $cnt=$cnt+1;}} ?>
                        </div>

                        <div class="col-lg-4 col-md-5 col-12 mx-auto">
                            <div class="featured-circle bg-white shadow-lg d-flex justify-content-center align-items-center">
                                <p class="featured-text"><span class="featured-number">12</span> Years<br> of Experiences</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="gallery">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-6 ps-0">
                            <img src="images/gallery/medium-shot-man-getting-vaccine.jpg" class="img-fluid galleryImage" alt="get a vaccine" title="get a vaccine for yourself">
                        </div>

                        <div class="col-lg-6 col-6 pe-0">
                            <img src="images/gallery/female-doctor-with-presenting-hand-gesture.jpg" class="img-fluid galleryImage" alt="wear a mask" title="wear a mask to protect yourself">
                        </div>

                    </div>
                </div>
            </section>

            <!-- Booking Modal -->
            <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingModalLabel">
                                <i class="bi bi-calendar-check me-2"></i>
                                Book an Appointment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="booking-form">
                                <p class="text-center text-muted mb-4">Fill out the form below to schedule your appointment with our experienced doctors</p>
                                
                                <!-- Progress Indicator -->
                                <div class="progress mb-4" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%; transition: width 0.3s ease;" id="modalFormProgress"></div>
                                </div>
                            
                                <form role="form" method="post" id="modalAppointmentForm">
                                    <!-- Personal Information Section -->
                                    <div class="form-section mb-4">
                                        <h4 class="section-title">
                                            <i class="bi bi-person-circle me-2"></i>
                                            Personal Information
                                        </h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-name" class="form-label">Full Name *</label>
                                                    <input type="text" name="name" id="modal-name" class="form-control" placeholder="Enter your full name" required='true'>
                                                    <div class="form-text">Please enter your complete name as it appears on your ID</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-email" class="form-label">Email Address *</label>
                                                    <input type="email" name="email" id="modal-email" class="form-control" placeholder="Enter your email address" required='true'>
                                                    <div class="form-text">We'll send confirmation to this email</div>
                                                </div>
                                            </div>
                                       
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-phone" class="form-label">Phone Number *</label>
                                                    <input type="tel" name="phone" id="modal-phone" class="form-control" placeholder="Enter 10-digit phone number" maxlength="10" pattern="[0-9]{10}" required>
                                                    <div class="form-text">For appointment reminders and updates</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Appointment Details Section -->
                                    <div class="form-section mb-4">
                                        <h4 class="section-title">
                                            <i class="bi bi-calendar-event me-2"></i>
                                            Appointment Details
                                        </h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-date" class="form-label">Preferred Date *</label>
                                                    <input type="date" name="date" id="modal-date" class="form-control" required>
                                                    <div class="form-text">Select your preferred appointment date</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-time" class="form-label">Preferred Time *</label>
                                                    <input type="time" name="time" id="modal-time" class="form-control" required>
                                                    <div class="form-text">Select your preferred appointment time</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Medical Information Section -->
                                    <div class="form-section mb-4">
                                        <h4 class="section-title">
                                            <i class="bi bi-heart-pulse me-2"></i>
                                            Medical Information
                                        </h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-specialization" class="form-label">Specialization *</label>
                                                    <select onChange="getdoctorsModal(this.value);" name="specialization" id="modal-specialization" class="form-control" required>
                                                        <option value="">Select specialization</option>
                                                        <?php
                                                        $sql="SELECT * FROM tblspecialization ORDER BY Specialization ASC";
                                                        $stmt=$dbh->query($sql);
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        while($row =$stmt->fetch()) { 
                                                        ?>
                                                        <option value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="form-text">Choose the medical specialty you need</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="modal-doctorlist" class="form-label">Select Doctor *</label>
                                                        <select name="doctorlist" id="modal-doctorlist" class="form-control" required>
                                                            <option value="">Select Doctor</option>
                                                        </select>
                                                        <div class="form-text">Choose your preferred doctor</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information Section -->
                                    <div class="form-section mb-4">
                                        <h4 class="section-title">
                                            <i class="bi bi-chat-text me-2"></i>
                                            Additional Information
                                        </h4>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="modal-message" class="form-label">Additional Message</label>
                                                    <textarea class="form-control" rows="4" id="modal-message" name="message" placeholder="Any specific symptoms, concerns, or additional information you'd like to share with the doctor..."></textarea>
                                                    <div class="form-text">Optional: Describe your symptoms or reason for visit</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Section -->
                                    <div class="form-section text-center">
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-lg px-5" name="submit" id="modal-submit-button">
                                                    <span class="btn-text">
                                                        <i class="bi bi-calendar-check me-2"></i>
                                                        Book Appointment
                                                    </span>
                                                    <span class="btn-loading d-none">
                                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                                        Processing...
                                                    </span>
                                                </button>
                                                <p class="text-muted mt-3 small">By clicking "Book Appointment", you agree to our terms and conditions</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php');?>
        
        <!-- JAVASCRIPT FILES - Optimized Loading -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js" defer></script>
        <script src="js/scrollspy.min.js" defer></script>
        <script src="js/custom.js" defer></script>
        
        <!-- Performance Monitoring -->
        <script>
            // Performance monitoring
            window.addEventListener('load', function() {
                const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                console.log('Page load time:', loadTime + 'ms');
                
                // Send performance data to analytics (if needed)
                if (loadTime > 3000) {
                    console.warn('Page load time is slow:', loadTime + 'ms');
                }
            });
            
            // Service Worker for caching (optional)
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js')
                        .then(function(registration) {
                            console.log('SW registered: ', registration);
                        })
                        .catch(function(registrationError) {
                            console.log('SW registration failed: ', registrationError);
                        });
                });
            }
        </script>
    </body>
</html>