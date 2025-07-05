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
        <title>Book Appointment - Doctor Appointment Management System</title>
        
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

        // Page load optimizations
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date and time for form
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            const dateInput = document.getElementById('date');
            const timeInput = document.getElementById('time');
            
            if (dateInput) {
                dateInput.min = tomorrow.toISOString().split('T')[0];
                dateInput.value = tomorrow.toISOString().split('T')[0];
            }
            
            if (timeInput) {
                timeInput.value = '09:00';
            }
        });
        </script>
    </head>
    
    <body id="top">
        <main>
            <?php include_once('includes/header.php');?>

            <!-- Page Header -->
            <section class="section-padding" style="background: linear-gradient(135deg, #f8fbff 0%, #e0eaff 100%); padding-top: 120px;">
                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <h1 class="display-5 fw-bold mb-3" style="color: var(--primary-color);">Book Your Appointment</h1>
                            <p class="lead mb-0" style="color: #333;">Fill out the form below to schedule your appointment with our experienced doctors</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Booking Form Section -->
            <section class="section-padding">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12">
                            <div class="booking-form bg-white shadow-lg rounded-3 p-5">
                                <form role="form" method="post" id="appointmentForm">
                                    <!-- Personal Information Section -->
                                    <div class="form-section mb-5">
                                        <h4 class="section-title mb-4">
                                            <i class="bi bi-person-circle me-2 text-primary"></i>
                                            Personal Information
                                        </h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label fw-semibold">Full Name *</label>
                                                    <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter your full name" required='true'>
                                                    <div class="form-text">Please enter your complete name as it appears on your ID</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="email" class="form-label fw-semibold">Email Address *</label>
                                                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter your email address" required='true'>
                                                    <div class="form-text">We'll send confirmation to this email</div>
                                                </div>
                                            </div>
                                       
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                                                    <input type="tel" name="phone" id="phone" class="form-control form-control-lg" placeholder="Enter 10-digit phone number" maxlength="10" pattern="[0-9]{10}" required>
                                                    <div class="form-text">For appointment reminders and updates</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Appointment Details Section -->
                                    <div class="form-section mb-5">
                                        <h4 class="section-title mb-4">
                                            <i class="bi bi-calendar-event me-2 text-primary"></i>
                                            Appointment Details
                                        </h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="date" class="form-label fw-semibold">Preferred Date *</label>
                                                    <input type="date" name="date" id="date" class="form-control form-control-lg" required>
                                                    <div class="form-text">Select your preferred appointment date</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="time" class="form-label fw-semibold">Preferred Time *</label>
                                                    <input type="time" name="time" id="time" class="form-control form-control-lg" required>
                                                    <div class="form-text">Select your preferred appointment time</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Medical Information Section -->
                                    <div class="form-section mb-5">
                                        <h4 class="section-title mb-4">
                                            <i class="bi bi-heart-pulse me-2 text-primary"></i>
                                            Medical Information
                                        </h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="specialization" class="form-label fw-semibold">Specialization *</label>
                                                    <select onChange="getdoctors(this.value);" name="specialization" id="specialization" class="form-control form-control-lg" required>
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
                                                    <label for="doctorlist" class="form-label fw-semibold">Select Doctor *</label>
                                                    <select name="doctorlist" id="doctorlist" class="form-control form-control-lg" required>
                                                        <option value="">Select Doctor</option>
                                                    </select>
                                                    <div class="form-text">Choose your preferred doctor</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information Section -->
                                    <div class="form-section mb-5">
                                        <h4 class="section-title mb-4">
                                            <i class="bi bi-chat-text me-2 text-primary"></i>
                                            Additional Information
                                        </h4>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="message" class="form-label fw-semibold">Additional Message</label>
                                                    <textarea class="form-control form-control-lg" rows="4" id="message" name="message" placeholder="Any specific symptoms, concerns, or additional information you'd like to share with the doctor..."></textarea>
                                                    <div class="form-text">Optional: Describe your symptoms or reason for visit</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Section -->
                                    <div class="form-section text-center">
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3" name="submit" id="submit-button">
                                                    <i class="bi bi-calendar-check me-2"></i>
                                                    Book Appointment
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
            </section>
        </main>
        
        <?php include_once('includes/footer.php');?>
        
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html> 