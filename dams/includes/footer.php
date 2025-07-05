<footer class="site-footer section-padding" id="contact">
            <div class="container">
                <!-- Reviews Section in Footer -->
                <div class="row mb-5">
                    <div class="col-12">
                        <h2 class="text-center mb-lg-4 mb-3 text-white">What Our Patients Say</h2>
                        <p class="text-center text-light mb-5">Read testimonials from our satisfied patients</p>
                    </div>
                </div>
                
                <div class="row mb-5">
                    <?php
                    // Array of review data with random names, addresses, and testimonials
                    $reviews = array(
                        array(
                            'image' => './images/reviews/beautiful-woman-face-portrait-brown-background.jpg',
                            'name' => 'Priya Sharma',
                            'age' => 28,
                            'address' => 'Mumbai, Maharashtra',
                            'rating' => 5,
                            'testimonial' => 'The appointment booking process was incredibly smooth and user-friendly. The doctor was professional and took the time to listen to my concerns. Highly recommended!',
                            'specialization' => 'General Checkup'
                        ),
                        array(
                            'image' => './images/reviews/portrait-british-woman.jpg',
                            'name' => 'Emily Rodriguez',
                            'age' => 35,
                            'address' => 'Bangalore, Karnataka',
                            'rating' => 5,
                            'testimonial' => 'I was impressed by the efficiency of the online booking system. The doctor was knowledgeable and the staff was very caring. Great experience overall!',
                            'specialization' => 'Cardiology'
                        ),
                        array(
                            'image' => './images/reviews/senior-man-wearing-white-face-mask-covid-19-campaign-with-design-space.jpg',
                            'name' => 'Rajesh Kumar',
                            'age' => 62,
                            'address' => 'Delhi, NCR',
                            'rating' => 5,
                            'testimonial' => 'As a senior patient, I appreciate the easy-to-use booking system. The doctor was patient and thorough in explaining everything. Excellent service!',
                            'specialization' => 'Internal Medicine'
                        ),
                        array(
                            'image' => './images/reviews/woman-wearing-mask-face-closeup-covid-19-green-background.jpg',
                            'name' => 'Fatima Ahmed',
                            'age' => 41,
                            'address' => 'Hyderabad, Telangana',
                            'rating' => 5,
                            'testimonial' => 'The online appointment booking saved me so much time! The doctor was professional and the facility was clean and modern. Will definitely return.',
                            'specialization' => 'Dermatology'
                        ),
                        array(
                            'image' => './images/reviews/beautiful-woman-face-portrait-brown-background.jpg',
                            'name' => 'Anjali Patel',
                            'age' => 32,
                            'address' => 'Pune, Maharashtra',
                            'rating' => 5,
                            'testimonial' => 'Excellent service! The online booking was quick and the doctor was very thorough. The staff was friendly and professional.',
                            'specialization' => 'Gynecology'
                        ),
                        array(
                            'image' => './images/reviews/portrait-british-woman.jpg',
                            'name' => 'Sofia Johnson',
                            'age' => 29,
                            'address' => 'Chennai, Tamil Nadu',
                            'rating' => 5,
                            'testimonial' => 'Very convenient booking system. The doctor was knowledgeable and the consultation was comprehensive. Highly satisfied!',
                            'specialization' => 'Pediatrics'
                        ),
                        array(
                            'image' => './images/reviews/senior-man-wearing-white-face-mask-covid-19-campaign-with-design-space.jpg',
                            'name' => 'Amit Singh',
                            'age' => 45,
                            'address' => 'Kolkata, West Bengal',
                            'rating' => 5,
                            'testimonial' => 'Great experience with the online booking. The doctor was professional and the treatment was effective. Will recommend to others.',
                            'specialization' => 'Orthopedics'
                        ),
                        array(
                            'image' => './images/reviews/woman-wearing-mask-face-closeup-covid-19-green-background.jpg',
                            'name' => 'Zara Khan',
                            'age' => 38,
                            'address' => 'Ahmedabad, Gujarat',
                            'rating' => 5,
                            'testimonial' => 'The booking process was seamless and the doctor was excellent. Very satisfied with the quality of care received.',
                            'specialization' => 'Neurology'
                        )
                    );
                    
                    // Shuffle the reviews for random order and select only 4 for display
                    shuffle($reviews);
                    $displayReviews = array_slice($reviews, 0, 4);
                    
                    foreach($displayReviews as $review) {
                        // Check if image file exists
                        $imagePath = $review['image'];
                        $imageExists = file_exists($imagePath);
                    ?>
                    <div class="col-lg-6 col-md-6 col-12 mb-5">
                        <div class="review-card-footer">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        <?php if ($imageExists): ?>
                                            <img src="<?php echo $imagePath; ?>" alt="<?php echo $review['name']; ?>" class="img-fluid" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="avatar-fallback" style="display: none; width: 100%; height: 100%; background: linear-gradient(45deg, var(--primary-color), #0056b3); color: white; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">
                                                <?php echo strtoupper(substr($review['name'], 0, 1)); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="avatar-fallback" style="width: 100%; height: 100%; background: linear-gradient(45deg, var(--primary-color), #0056b3); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">
                                                <?php echo strtoupper(substr($review['name'], 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="reviewer-details">
                                        <h5 class="reviewer-name text-white"><?php echo $review['name']; ?></h5>
                                        <p class="reviewer-age text-light"><?php echo $review['age']; ?> years old</p>
                                        <p class="reviewer-address text-light"><?php echo $review['address']; ?></p>
                                        <p class="reviewer-specialization text-light"><?php echo $review['specialization']; ?></p>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <?php for($i = 1; $i <= 5; $i++) { ?>
                                        <i class="bi bi-star-fill <?php echo $i <= $review['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="review-content">
                                <p class="review-text text-light">"<?php echo $review['testimonial']; ?>"</p>
                            </div>
                            <div class="review-footer">
                                <i class="bi bi-quote text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                
                <!-- Stats Section -->
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <div class="stats-section-footer">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12 mb-3">
                                    <div class="stat-item-footer">
                                        <div class="stat-number text-white">500+</div>
                                        <div class="stat-label text-light">Happy Patients</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 mb-3">
                                    <div class="stat-item-footer">
                                        <div class="stat-number text-white">4.9</div>
                                        <div class="stat-label text-light">Average Rating</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 mb-3">
                                    <div class="stat-item-footer">
                                        <div class="stat-number text-white">15+</div>
                                        <div class="stat-label text-light">Expert Doctors</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 mb-3">
                                    <div class="stat-item-footer">
                                        <div class="stat-number text-white">98%</div>
                                        <div class="stat-label text-light">Satisfaction Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Original Footer Content -->
                <div class="row">
                    <div class="col-lg-5 me-auto col-12">
                        <?php
$sql="SELECT * from tblpage where PageType='contactus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                        <h5 class="mb-lg-4 mb-3">Timing</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">

                                <?php  echo ($row->Timing);?>
                            </li></ul>
                            <h5 class="mb-lg-4 mb-3">Email</h5>
                            <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <?php  echo ($row->Email);?></li>
                                <br>
                                 <h5 class="mb-lg-4 mb-3">Contact Number</h5>
                            <li class="list-group-item d-flex">
                                <?php  echo ($row->MobileNumber);?></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12 my-4 my-lg-0">
                        <h5 class="mb-lg-4 mb-3">Our Clinic</h5>

                     

                        <p><?php  echo ($row->PageDescription);?></p>
                    </div>
<?php $cnt=$cnt+1;}} ?>
                    <div class="col-lg-3 col-md-6 col-12 ms-auto">
                        <h5 class="mb-lg-4 mb-2">Socials</h5>

                        <ul class="social-icon">
                            <li><a href="#" class="social-icon-link bi-facebook"></a></li>

                            <li><a href="#" class="social-icon-link bi-twitter"></a></li>

                            <li><a href="#" class="social-icon-link bi-instagram"></a></li>

                            <li><a href="#" class="social-icon-link bi-youtube"></a></li>
                        </ul>

                        
                    </div>

                   

                </div>
            </section>
        </footer>