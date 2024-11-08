<?php

session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Process the form data
		$name = $_POST["name"];
		$email = $_POST["email"];
		$subject = $_POST["subject"];
		$message = $_POST["message"];
		$key = $_POST["g-recaptcha-response"];
		// Perform form validation, e.g., check for empty fields$
		
		if (!empty($name) && !empty($email) && !empty($message) && !empty($key)) {
			// Form data is valid, proceed to send email
			
			try {
				
				$api_url = "https://www.google.com/recaptcha/api/siteverify";
				$data = array(
					'secret' => '6LfsF8spAAAAAJxQuONk9hH08luQLRUl2AD0zLTk',
					'response' => $_POST["g-recaptcha-response"],
					'remoteip' => ""
				);
				
				$ch = curl_init($api_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

				$response = curl_exec($ch);
				curl_close($ch);
				$response = json_decode($response);
				if($response && $response->success){

					// echo $response;
					$webhookUrl = "https://hooks.slack.com/services/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";
					$message = "Name: " . $name . " \n Email: " . $email . " \n Message: " . $message;
				
					
					$data = array(
						"text" => $message,
					);

					$options = array(
						"http" => array(
							"header" => "Content-type: application/json",
							"method" => "POST",
							"content" => json_encode($data),
						),
					);

					$context = stream_context_create($options);
					$result = file_get_contents($webhookUrl, false, $context);
					if ($result === false) {
						$message =  "Error sending the message.";
						
					} else {
						$message = "Message sent successfully.";
						$_SESSION["sent"] = 1;
					}
					unset($_SESSION['csrf_token']);
					
				}
				
			} catch (\Exception $e) {
				//throw $th;
				throw $e;
			}
		
		} else {
			echo "Please fill in all the fields.";
            $message = "Please fill in all the fields.";
		}


    } else {
        // Token mismatch: handle refresh scenario
        // ...
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MT &mdash; Application developer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Professional portfolio website." />
    <meta name="keywords" content="myothu programmar webdeveloper" />
    <meta name="author" content="myothu" />
    <link rel="icon" type="image/png" href="images/favicon.png">


    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />

    <link href="https://fonts.googleapis.com/css?family=Space+Mono" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->
    <script>
    function redirectToFacebook() {
        window.location.href = "twitter://profile/myo7hu"; // Replace with the actual page ID
    }
    </script>

</head>

<body>

    <div class="fh5co-loader"></div>

    <div id="page">
        <header id="fh5co-header" class="fh5co-cover js-fullheight" role="banner"
            style="background-image:url(images/background.jpg);" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <div class="display-t js-fullheight">
                            <div class="display-tc js-fullheight animate-box" data-animate-effect="fadeIn">
                                <div class="profile-thumb" style="background: url(images/me.jpg);"></div>
                                <h1><span>Myo Thu</span></h1>
                                <h3><span>Application Developer</span></h3>
                                <p>
                                <ul class="fh5co-social-icons">
                                    <li><a href="https://twitter.com/myo7hu"><i class="icon-twitter2"></i></a></li>
                                    <li><a href="https://facebook.com/myo7hu"><i class="icon-facebook2"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/myo-thu-533a6a81"><i
                                                class="icon-linkedin2"></i></a></li>
                                    <!-- <li><a href="#"  onclick="redirectToFacebook()"><i class="icon-linkedin2"></i></a></li> -->
                                    <!-- <li><a href="#"><i class="icon-dribbble2"></i></a></li> -->
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="fh5co-about" class="animate-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <h2>About Me</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="info">
                            <li><span class="first-block">Full Name:</span><span class="second-block">Myo Thu</span>
                            </li>
                            <li><span class="first-block">Phone:</span><span class="second-block">+95 962602671</span>
                            </li>
                            <li><span class="first-block">Email:</span><span
                                    class="second-block">myoothu.jva@gmail.com</span></li>
                            <li><span class="first-block">Website:</span><span
                                    class="second-block">https://myothu.info</span></li>
                            <li><span class="first-block">Address:</span><span class="second-block">North Okkalapa Tsp,
                                    Yangon</span></li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <h2>Hello There!</h2>
                        <p>
                            👋 Greetings, I'm Myo Thu, a dedicated backend developer with a rich expertise in Node.js
                            and Laravel, as well as a passion for crafting dynamic web applications. With a keen focus
                            on shaping the unseen architecture that powers applications, I thrive on turning complex
                            challenges into elegant solutions. Over the course of my career, I've honed my skills to
                            become a trusted expert in creating efficient and scalable backend systems that empower
                            seamless user experiences.
                        </p>
                        <p>
                            🌐 In addition to my backend proficiency, I also bring a wealth of experience in developing
                            immersive web applications. With a mastery of front-end technologies like HTML, CSS, and
                            JavaScript, I've designed and created interactive interfaces that captivate users and
                            provide them with exceptional online journeys. Collaborating closely with design teams, I've
                            woven the threads of creativity and technology to create web applications that truly stand
                            out.
                        </p>

                        <p>
                        <ul class="fh5co-social-icons">
                            <li><a href="https://facebook.com/myo7hu"><i class="icon-twitter2"></i></a></li>
                            <li><a href="https://twitter.com/myo7hu"><i class="icon-facebook3"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/myo-thu-533a6a81"><i
                                        class="icon-linkedin2"></i></a></li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="fh5co-resume" class="fh5co-bg-color">
            <div class="container">
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <h2>My Resume</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <ul class="timeline">
                            <li class="timeline-heading text-center animate-box">
                                <div>
                                    <h3>Work Experience</h3>
                                </div>
                            </li>
                            <li class="animate-box timeline-unverted">
                                <div class="timeline-badge"><i class="icon-suitcase"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Senior Backend Developer</h3>
                                        <span class="company">Bagan Innovation Technology - 2023</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            In the realm of backend development, I've orchestrated the creation of
                                            robust chatbot and live chat applications by seamlessly integrating PHP and
                                            Node.js. Leveraging PHP, I've engineered intelligent chatbots that offer
                                            tailored interactions and streamline user engagement. Concurrently, my
                                            mastery of Node.js has empowered me to construct real-time live chat systems
                                            that enable instantaneous and dynamic communication. These endeavors
                                            entailed skillful utilization of both MySQL for structured data management
                                            and MongoDB for scalable, adaptable storage solutions.

                                            Furthermore, my proficiency extends to Laravel, where I've developed
                                            powerful backend APIs that fuel both mobile and web applications.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted animate-box">
                                <div class="timeline-badge"><i class="icon-suitcase"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Senior Web Developer</h3>
                                        <span class="company">New Wave Technology - 2017</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>My journey includes versatile backend API development across various
                                            projects, utilizing both PHP and Node.js to deliver tailored solutions. With
                                            PHP, I've architectured robust APIs that ensure seamless functionality and
                                            data integrity, driving user interactions on the web. On the other hand, my
                                            proficiency in Node.js allowed me to create real-time, asynchronous APIs
                                            that power dynamic applications, enhancing user engagement and
                                            responsiveness. My adaptability in utilizing PHP and Node.js for distinct
                                            projects underscores my dedication to crafting backend solutions that cater
                                            to specific project needs. This diverse experience solidifies my expertise
                                            in backend development, making me a valuable asset for creating innovative
                                            and efficient APIs.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="animate-box timeline-unverted">
                                <div class="timeline-badge"><i class="icon-suitcase"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Senior Application Developer</h3>
                                        <span class="company">Eunovate Technology - 2016</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>With a strong background in application development, I have successfully
                                            contributed to projects spanning both Android and web platforms. Leveraging
                                            my expertise, I have crafted intuitive and feature-rich Android applications
                                            that cater to diverse user needs. Simultaneously, my proficiency in web
                                            development has enabled me to design and develop responsive and engaging web
                                            applications that deliver seamless user experiences. Through collaborative
                                            efforts and meticulous attention to detail, I have consistently delivered
                                            solutions that bridge the gap between technology and user expectations. My
                                            versatile skill set allows me to create impactful applications that thrive
                                            in today's dynamic digital landscape.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted animate-box">
                                <div class="timeline-badge"><i class="icon-suitcase"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Web Developer</h3>
                                        <span class="company">Active Agent - 2015</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>As a dedicated web developer at Active Agent, I played a pivotal role in
                                            creating a seamless Order Management System powered by PHP. Leveraging PHP's
                                            capabilities, I meticulously crafted the system's backend to facilitate
                                            smooth order processing, efficient inventory management, and real-time
                                            updates. Collaborating closely with our design team, I ensured a harmonious
                                            integration of user-friendly interfaces with robust functionalities. This
                                            experience not only honed my PHP skills but also emphasized my commitment to
                                            delivering effective solutions that optimize business operations.</p>
                                    </div>
                                </div>
                            </li>

                            <li class="animate-box timeline-unverted">
                                <div class="timeline-badge"><i class="icon-suitcase"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Web Developer</h3>
                                        <span class="company">Arrigatoo - 2014</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>At Arrigatoo, I led Java web development for an online wedding platform.
                                            Utilizing Java's capabilities, I crafted backend solutions for user
                                            management, RSVPs, and more. Collaborating with designers, I ensured a
                                            seamless fusion of design and functionality. This experience enhanced my
                                            Java skills and highlighted my ability to deliver user-centric solutions.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <br>
                            <li class="timeline-heading text-center animate-box">
                                <div>
                                    <h3>Education</h3>
                                </div>
                            </li>
                            <li class="timeline-inverted animate-box">
                                <div class="timeline-badge"><i class="icon-graduation-cap"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Bachelors Degree - B.A(Eco)</h3>
                                        <span class="company">Hinthada University - 2006 - 2008</span>
                                    </div>
                                    <!-- <div class="timeline-body">
									<p>Far far away, behind the word mountains, they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
								</div> -->
                                </div>
                            </li>
                            <li class="animate-box timeline-unverted">
                                <div class="timeline-badge"><i class="icon-graduation-cap"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h3 class="timeline-title">Programming and Software Development</h3>
                                        <span class="company">Gusto - 2008 - 2009</span>
                                    </div>
                                    <!-- <div class="timeline-body">
									<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
								</div> -->
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div id="fh5co-features" class="animate-box">
            <div class="container">
                <div class="services-padding">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                            <h2>My Services</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="feature-left">
                                <span class="icon">
                                    <i class="icon-global"></i>
                                </span>
                                <div class="feature-copy">
                                    <h3>Website Development</h3>
                                    <p>Tailored personal website development, blending creativity with technical skill
                                        to craft unique and engaging digital experiences that resonate.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-center">
                            <div class="feature-left">
                                <span class="icon">
                                    <i class="icon-mobile"></i>
                                </span>
                                <div class="feature-copy">
                                    <h3>Mobile Development</h3>
                                    <p>Crafting mobile experiences that engage and innovate. Expert in iOS, Android, and
                                        cross-platform development, ensuring seamless functionality and user
                                        satisfaction.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 text-center">
                            <div class="feature-left">
                                <span class="icon">
                                    <i class="icon-chat"></i>
                                </span>
                                <div class="feature-copy">
                                    <h3>Social Chatbots</h3>
                                    <p>Revolutionize interactions with cutting-edge social chatbots. Enhance engagement
                                        and streamline communication for a dynamic and connected user experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="fh5co-skills" class="animate-box">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <h2>Skills</h2>
                </div>
            </div>
            <div class="row row-pb-md">
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="85"><span><strong>Laravel</strong>85%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="90"><span><strong>NodeJS</strong>90%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="80"><span><strong>HTML</strong>80%</span></div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="70"><span><strong>CSS</strong>70%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="70"><span><strong>ReactJS</strong>80%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="60"><span><strong>Android</strong>60%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="85"><span><strong>MySQL</strong>85%</span></div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="80"><span><strong>MongoDB</strong>80%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="80"><span><strong>Redis</strong>80%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="70"><span><strong>StrapiCMS</strong>70%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="80"><span><strong>Docker</strong>80%</span></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="chart" data-percent="70"><span><strong>Nginx</strong>70%</span></div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="progress-wrap">
                        <h3><span class="name-left">Laravel</span><span class="value-right">85%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-1 progress-bar-striped active" role="progressbar"
                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">NodeJS</span><span class="value-right">90%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-2 progress-bar-striped active" role="progressbar"
                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">HTML</span><span class="value-right">80%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-3 progress-bar-striped active" role="progressbar"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">CSS</span><span class="value-right">70%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-4 progress-bar-striped active" role="progressbar"
                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">ReactJS</span><span class="value-right">80%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-5 progress-bar-striped active" role="progressbar"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">Android</span><span class="value-right">60%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="70"
                                aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="progress-wrap">
                        <h3><span class="name-left">MySQL</span><span class="value-right">85%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-5 progress-bar-striped active" role="progressbar"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:85%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">MongoDB</span><span class="value-right">80%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="70"
                                aria-valuemin="0" aria-valuemax="100" style="width:80%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">Redis</span><span class="value-right">80%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-1 progress-bar-striped active" role="progressbar"
                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">StrapiCMS</span><span class="value-right">70%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-3 progress-bar-striped active" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">Docker</span><span class="value-right">80%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-1 progress-bar-striped active" role="progressbar"
                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-wrap">
                        <h3><span class="name-left">Nginx</span><span class="value-right">70%</span></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-2 progress-bar-striped active" role="progressbar"
                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fh5co-work" class="fh5co-bg-dark">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <h2>Work</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="" class="work" style="background-image: url(images/qeelin.png);">
                        <div class="desc">
                            <h3>Qeelin</h3>
                            <span>Online Jewelry Shopping Website.</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="" class="work" style="background-image: url(images/serge-luten.png);">
                        <div class="desc">
                            <h3>Serge Luten</h3>
                            <span>Online Comestic Shopping Website.</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="https://chatbot.tharapa.ai" class="work"
                        style="background-image: url(images/tharapa.jpeg);">
                        <div class="desc">
                            <h3>Tharapa Chatbot</h3>
                            <span>Tharapa Chatbot builder</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="https://www.readsnote.com" class="work"
                        style="background-image: url(images/readsnote.png);">
                        <div class="desc">
                            <h3>Reads Note</h3>
                            <span>Book Reviews and Ratings Website</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="https://play.google.com/store/apps/details?id=com.bit.tharapa&hl=en&gl=US" class="work"
                        style="background-image: url(images/tharapa.webp);">
                        <div class="desc">
                            <h3>Tharapa Admin</h3>
                            <span>Mobile Application for Online Shop Management</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="https://play.google.com/store/apps/details?id=com.bit.wunzin&hl=en&gl=US" class="work"
                        style="background-image: url(images/wunzin.webp);">
                        <div class="desc">
                            <h3>Wunzinn</h3>
                            <span>Online book reader</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a class="work" style="background-image: url(images/td.png);">
                        <div class="desc">
                            <h3>Translator's Digest</h3>
                            <span>News & Articles Mobile application</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a class="work" style="background-image: url(images/carediary.png);">
                        <div class="desc">
                            <h3>Care Diary</h3>
                            <span>Mobile Health Assistance Application.</span>
                        </div>
                    </a>
                </div>


                <div class="col-md-3 text-center col-padding animate-box">
                    <a href="https://t.me/mmhealth_bot" class="work" style="background-image: url(images/bot.jpg);"
                        target="_blank">
                        <div class="desc">
                            <h3>MM Health</h3>
                            <span>Health Assistance Telegram Bot</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a class="work" style="background-image: url(images/env.png);">
                        <div class="desc">
                            <h3>Environmental Management CMS</h3>
                            <!-- <span>Mobile Health Assistance Application.</span> -->
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a class="work" style="background-image: url(images/sales.png);">
                        <div class="desc">
                            <h3>Admin Dashboard</h3>
                            <span>Sale and product management System</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 text-center col-padding animate-box">
                    <a class="work" style="background-image: url(images/order.jpeg);">
                        <div class="desc">
                            <h3>Order Management System</h3>
                            <span>Manage order, inventory, supplier</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div id="fh5co-blog">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <h2>Post on Medium</h2>
                    <p>Feel Free to Explore and Read My Article on Medium.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="fh5co-blog animate-box">
                        <a href="#" class="blog-bg" style="background-image: url(images/headless_cms.webp);"></a>
                        <div class="blog-text">
                            <span class="posted_on">Mar. 23th 2023</span>
                            <h3><a href="#">Fall in love at Headless CMS</a></h3>
                            <p>Headless CMS ဆိုတာဘာကြီးတုန်း ? ...</p>
                            <ul class="stuff">
                                <!-- <li><i class="icon-heart2"></i>249</li>
								<li><i class="icon-eye2"></i>308</li> -->
                                <li><a href="https://myo7hu.medium.com/fall-in-love-at-headless-cms-419e774bbe64">Read
                                        More<i class="icon-arrow-right22"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fh5co-blog animate-box">
                        <a href="#" class="blog-bg" style="background-image: url(images/mysql_replication_.webp);"></a>
                        <div class="blog-text">
                            <span class="posted_on">Mar. 15th 2016</span>
                            <h3><a href="#">Mysql Database Replication</a></h3>
                            <p>mysql replication ဆိုတာ ကိုယ့်ရဲ ဒေတာဘေစ်ကို copy ပြုလုပ်ချင်းပါပဲ။</p>
                            <ul class="stuff">
                                <li><i class="icon-heart2"></i>249</li>
                                <li><i class="icon-eye2"></i>308</li>
                                <li><a href="#">Read More<i class="icon-arrow-right22"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fh5co-blog animate-box">
                        <a href="#" class="blog-bg" style="background-image: url(images/mysql_replication_2.webp);"></a>
                        <div class="blog-text">
                            <span class="posted_on">Mar. 15th 2016</span>
                            <h3><a href="#">Mysql Database Replication အပိုင်း (၂)</a></h3>
                            <p>အရင်တစ်ပတ်က mysql replication ကို binary logs နဲ့ လုပ်တာ ပြောခဲ့တာဖြစ်ပါတယ်။
                                အခုကျွန်တော်ပြောပြပေးမှာက replication ကို GTID နဲ့ လုပ်တဲ့ပိုင်းကို ပြောပြပေးပါမယ်။</p>
                            <ul class="stuff">
                                <li><i class="icon-heart2"></i>249</li>
                                <li><i class="icon-eye2"></i>308</li>
                                <li><a href="#">Read More<i class="icon-arrow-right22"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fh5co-started" class="fh5co-bg-dark">
        <div class="overlay"></div>
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <h2>Let's connect!</h2>
                    <p>Collaboration drives innovation, and I'm excited to embark on new projects together. Whether it's
                        crafting cutting-edge web applications, honing backend functionalities, or bringing digital
                        visions to life, I'm here to contribute my skills and expertise. Let's connect and discuss how
                        we can create impactful solutions that resonate in today's dynamic digital landscape.</p>
                    <p><a href="#" class="btn btn-default btn-lg">Contact Me</a></p>
                </div>
            </div>
        </div>
    </div>

    <div id="fh5co-consult">
        <div class="video fh5co-video" style="background-image: url(images/contact-me.jpg);    
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;">
            <div class="overlay"></div>
        </div>
        <div class="choose animate-box">
            <p class="text-primary">
                <?php 
					if($message != "")
						echo $message 
				?>
            </p>
            <h2>Contact</h2>
            <?php 

			// Generate a unique token
			$token = bin2hex(random_bytes(32));
			$_SESSION['csrf_token'] = $token;
			?>
            <form action="#" method="post">
                <div class="row form-group">
                    <div class="col-md-6">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Your name" required>
                        <input type="hidden" id="csrf_token" name="csrf_token" class="form-control"
                            placeholder="Your name" required value="<?php echo $token; ?>">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <input type="text" id="email" name="email" class="form-control" placeholder="Your email address"
                            required>
                    </div>
                </div>

                <!-- <div class="row form-group">
					<div class="col-md-12">
						<input type="text" id="subject" name="subject" class="form-control" placeholder="Your subject of this message">
					</div>
				</div> -->

                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea name="message" id="message" name="message" cols="30" rows="10" class="form-control"
                            placeholder="Say something about us" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LfsF8spAAAAANBG0LRWLbXJowNbCCwiNZHtzqsO"></div>
                    <br />
                    <input type="submit" value="Send Message" class="btn btn-primary">
                </div>

            </form>
        </div>
    </div>

    <!-- <div id="map" class="fh5co-map"></div>
	</div> -->

    <div id="fh5co-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>&copy; 2023. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up22"></i></a>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- jQuery Easing -->
    <script src="js/jquery.easing.1.3.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.waypoints.min.js"></script>
    <!-- Stellar Parallax -->
    <script src="js/jquery.stellar.min.js"></script>
    <!-- Easy PieChart -->
    <script src="js/jquery.easypiechart.min.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false">
    </script>
    <script src="js/google_map.js"></script>

    <!-- Main -->
    <script src="js/main.js"></script>
    <script>
    var jsValue = <?php echo json_encode($message); ?>;
    if (jsValue != "") {
        location.href = "#fh5co-consult";
        // document.getElementById("fh5co-consult").scrollIntoView();
        // var element = document.getElementById('fh5co-consult');
        // console.log("element",element);
        // element.scrollIntoView({ behavior: 'smooth' });
    }
    </script>

</body>

</html>