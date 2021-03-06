<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Home</title>
	<link rel="icon" href="/aroma/img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="/aroma/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/aroma/vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="/aroma/vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="/aroma/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="/aroma/vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="/aroma/vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="/aroma/vendors/linericon/style.css">
  <link rel="stylesheet" href="/aroma/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="/aroma/vendors/nouislider/nouislider.min.css">

  <link rel="stylesheet" href="/aroma/css/style.css">
</head>
<body>
  <!--================ Start Header Menu Area =================-->
	<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="/"><img src="aroma/img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="/">Home</a></li>
              <li class="nav-item submenu dropdown">
                <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Shop</a>
                <ul class="dropdown-menu">
                    <li class="nav-item submenu dropright">
                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Shop Category
                        </a>
                        <div class="dropdown-menu">
                           <?php require $this->checkTemplate("categories-menu");?>
                        </div>
                      </li>
                  <li class="nav-item"><a class="nav-link" href="/checkout">Product Checkout</a></li>
                  <li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
                  <li class="nav-item"><a class="nav-link" href="/cart">Shopping Cart</a></li>
                </ul>
							</li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Blog</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
                </ul>
							</li>
							<li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                  <li class="nav-item"><a class="nav-link" href="tracking-order.html">Tracking</a></li>
                </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
              <li class="nav-item"><a class="nav-link" href="/profile">Profile</a></li>
            </ul>

            <ul class="nav-shop">
              <li class="nav-item"><button><i class="ti-search"></i></button></li>
              <li class="nav-item"><a class="btn" href="/cart"><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></a> </li>
              <li class="nav-item"><a class="button button-header" href="#">Buy Now</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
	<!--================ End Header Menu Area =================-->