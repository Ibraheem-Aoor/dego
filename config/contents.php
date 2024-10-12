<?php
return [
    'relaxation_hero' => [
        'single' => [
            'field_name' => [
                'heading_part_one' => 'text',
                'heading_part_two' => 'text',
                'heading_part_three' => 'text',
                'sub_heading' => 'textarea',
                'video_link' => 'url',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'heading_part_one.*' => 'required|max:100',
                'heading_part_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'video_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme Hero Section'=>'assets/global/img/section/relaxation/hero.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_hero_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme Second Hero Section'=>'assets/global/img/section/relaxation/hero_two.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_search' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'image' => 'file',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'button_link.*' => 'required|max:200',
            ]
        ],
        'image' => [
            'Relaxation Theme Search Section'=>'assets/global/img/section/relaxation/search.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_search_two' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'image' => 'file',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'button_link.*' => 'required|max:200',
            ]
        ],
        'image' => [
            'Relaxation Theme Second Search Section'=>'assets/global/img/section/relaxation/search_two.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_popular_tour' => [
        'single' => [
            'field_name' => [
                'title_part_one' => 'text',
                'title_part_two' => 'text',
                'title_part_three' => 'text',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'title_part_one.*' => 'required|max:100',
                'title_part_two.*' => 'required|max:100',
                'title_part_three.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme Popular Tour Section'=>'assets/global/img/section/relaxation/popular_tour.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_contact' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'heading_text' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'email' => 'text',
                'address' => 'text',
                'phone' => 'text',
                'map_title' => 'text',
                'map' => 'textarea',
                'image' => 'file',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'heading_text.*' => 'required|max:300',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:200',
                'email.*' => 'required|max:100',
                'address.*' => 'required|max:100',
                'phone.*' => 'required|max:100',
                'map_title.*' => 'required|max:100',
                'map.*' => 'required|max:2000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ],
        ],
        'image' => [
            'Relaxation Theme Contact Section'=>'assets/global/img/section/relaxation/contact.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_booking' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'title' => 'text',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'title.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'description' => 'textarea',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Relaxation Theme Booking Section'=>'assets/global/img/section/relaxation/booking.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_blog' => [
        'single' => [
            'field_name' => [
                'title_part_one' => 'text',
                'title_part_two' => 'text',
                'heading' => 'text',
                'sub_heading' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title_part_one.*' => 'required|max:100',
                'title_part_two.*' => 'required|max:100',
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:300',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Relaxation Theme Blog Section'=>'assets/global/img/section/relaxation/blog.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_app' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button_link' => 'url',
                'button_link_two' => 'url',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
                'image_four' => 'file',
                'image_five' => 'file',
                'image_six' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:300',
                'button_link.*' => 'required|max:300',
                'button_link_two.*' => 'required|max:300',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_four.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_five.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_six.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme App Section'=>'assets/global/img/section/relaxation/app.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_about' => [
        'single' => [
            'field_name' => [
                'heading_part_one' => 'text',
                'heading_part_two' => 'text',
                'heading_part_three' => 'text',
                'sub_heading' => 'text',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
            ],
            'validation' => [
                'heading_part_one.*' => 'required|max:100',
                'heading_part_two.*' => 'required|max:100',
                'heading_part_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'topic' => 'text',
                'description' => 'textarea',
                'button_link' =>'url',
                'image' => 'file',

            ],
            'validation' => [
                'topic.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_link.*' => 'nullable|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Relaxation Theme About Section'=>'assets/global/img/section/relaxation/about.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_adventure' => [
        'single' => [
            'field_name' => [
                'heading_part_one' => 'text',
                'heading_part_two' => 'text',
                'sub_heading' => 'text',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
            ],
            'validation' => [
                'heading_part_one.*' => 'required|max:100',
                'heading_part_two.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Relaxation Theme Adventure Section'=>'assets/global/img/section/relaxation/adventure.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_inspiration_two' => [
        'single' => [
            'field_name' => [
                'heading_part_one' => 'text',
                'heading_part_two' => 'text',
                'heading_part_three' => 'text',
                'sub_heading' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
                'image_four' => 'file',
                'image_five' => 'file',
                'image_six' => 'file',
                'image_seven' => 'file',
            ],
            'validation' => [
                'heading_part_one.*' => 'required|max:100',
                'heading_part_two.*' => 'required|max:100',
                'heading_part_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'button.*' => 'required|max:500',
                'button_link.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_four.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_five.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_six.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_seven.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme Inspiration Section'=>'assets/global/img/section/relaxation/inspiration_two.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_inspiration' => [
        'single' => [
            'field_name' => [
                'heading_part_one' => 'text',
                'heading_part_two' => 'text',
                'heading_part_three' => 'text',
                'sub_heading' => 'text',
                'button_text' => 'text',
                'button_link' => 'url',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
                'image_four' => 'file',
                'image_five' => 'file',
                'image_six' => 'file',
            ],
            'validation' => [
                'heading_part_one.*' => 'required|max:100',
                'heading_part_two.*' => 'required|max:100',
                'heading_part_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'button_text.*' => 'required|max:100',
                'button_link.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_four.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_five.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_six.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme Inspiration Section'=>'assets/global/img/section/relaxation/inspiration.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_destination' => [
        'single' => [
            'field_name' => [
                'heading_part_one' => 'text',
                'heading_part_two' => 'text',
                'heading_part_three' => 'text',
                'sub_heading' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading_part_one.*' => 'required|max:100',
                'heading_part_two.*' => 'required|max:100',
                'heading_part_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme Destination Section'=>'assets/global/img/section/relaxation/relaxation_destination.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_testimonial'=>[
        'single'=>[
            'field_name'=>[
                'heading' => 'text',
                'image_one' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
                'image_four' => 'file',
                'image_five' => 'file',
                'image_six' => 'file',
                'image_seven' => 'file',
                'image_eight' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'image_one.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_four.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_five.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_six.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_seven.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_eight.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'address' => 'text',
                'description' => 'textarea',
                'image' => 'file',
            ],
            'validation' => [
                'name.*' => 'required|max:100',
                'address.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'image' => [
            'Relaxation Theme Testimonial Section'=>'assets/global/img/section/relaxation/testimonial.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_news_letter_two' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'button.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme News Letter Second Section'=>'assets/global/img/section/relaxation/news_letter_two.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_news_letter' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'button.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Relaxation Theme News Letter Section'=>'assets/global/img/section/relaxation/news_letter.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_about_three' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'button_name'=>'text',
                'button_link'=> 'url',
                'year_number' => 'text',
                'message' => 'text',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'button_name.*' => 'required|max:100',
                'button_link.*' => 'required|max:1000',
                'year_number.*' => 'required|max:6',
                'message.*' => 'required|max:300',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ],
        ],
        'image' => [
            'Relaxation Theme Section'=>'assets/global/img/section/relaxation/about_three.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_counter' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'topic' => 'text',
                'count_number' => 'number',
            ],
            'validation' => [
                'topic.*' => 'required|max:100',
                'count_number.*' => 'required|max:10',
            ]
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/counter.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_mission' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'circle_text' => 'text',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'circle_text.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'heading' => 'text',
                'description' => 'textarea',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
            ]
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/mission.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_team' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'heading_two' => 'text',
                'heading_three' => 'text',
                'sub_heading' => 'text',
                'image' => 'file'
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'heading_two.*' => 'required|max:100',
                'heading_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:400',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'designation' => 'text',
                'facebook' => 'text',
                'twitter' => 'text',
                'linkedin' => 'text',
                'instagram' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'name.*' => 'required|max:100',
                'designation.*' => 'required|max:100',
                'facebook.*' => 'required|max:100',
                'twitter.*' => 'required|max:100',
                'linkedin.*' => 'required|max:100',
                'instagram.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/team.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_faq' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'question' => 'text',
                'answer' => 'text',

            ],
            'validation' => [
                'question.*' => 'required|max:100',
                'answer.*' => 'required|max:500',
            ],
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/faq.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_login' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'submit_button' => 'text',
                'image' => 'file',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'submit_button.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/login.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_register' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'heading' => 'text',
                'sub_heading' => 'text',
                'image' => 'file',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/register.png',
        ],
        'theme' => 'relaxation'
    ],
    'relaxation_experience' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'heading_two' => 'text',
                'heading_three' => 'text',
                'button_text' => 'text',
                'button_link' => 'url',
                'total_customer' => 'text',
                'customer_text' => 'text',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
                'image_four' => 'file',
                'image_five' => 'file',
                'image_six' => 'file',
                'image_seven' => 'file',
                'image_eight' => 'file',
                'image_nine' => 'file',
                'image_ten' => 'file',
                'image_eleven' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'heading_two.*' => 'required|max:100',
                'heading_three.*' => 'required|max:100',
                'button_text.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
                'total_customer.*' => 'required|max:100',
                'customer_text.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_four.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_five.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_six.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_seven.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_eight.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_nine.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_ten.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_eleven.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'heading' => 'text',
                'description' => 'textarea',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'relaxation Theme Section'=>'assets/global/img/section/relaxation/experience.png',
        ],
        'theme' => 'relaxation'
    ],

    'package' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'heading_two' => 'text',
                'heading_three' => 'text',
                'sub_heading' => 'text',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'heading_two.*' => 'required|max:100',
                'heading_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Relaxation Theme package Section'=>'assets/global/img/section/relaxation/package.png',
            'Adventure Theme package Section'=>'assets/global/img/section/adventure/package.png',
        ],
        'theme' => 'all'
    ],
    'destination' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'heading_two' => 'text',
                'heading_three' => 'text',
                'sub_heading' => 'text',
                'popular_heading' => 'text',
                'popular_heading_two' => 'text',
                'popular_heading_three' => 'text',
                'popular_sub_heading' => 'text',
                'adventure_theme_heading' => 'text',
                'adventure_theme_sub_heading' => 'text',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'heading_two.*' => 'required|max:100',
                'heading_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'popular_heading.*' => 'required|max:100',
                'popular_heading_two.*' => 'required|max:100',
                'popular_heading_three.*' => 'required|max:100',
                'popular_sub_heading.*' => 'required|max:500',
                'adventure_theme_heading.*' => 'required|max:500',
                'adventure_theme_sub_heading.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'relaxation Theme Destination Section'=>'assets/global/img/section/relaxation/destination.png',
            'Adventure Theme Destination Section'=>'assets/global/img/section/adventure/destination.png',
        ],
        'theme' => 'all'
    ],
    'adventure_register' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'heading' => 'text',
                'sub_heading' => 'text',
                'login_button' => 'text',
                'sign_up_button' => 'text'

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'login_button.*' => 'required|max:100',
                'sign_up_button.*' => 'required|max:100',
            ]
        ],
        'image' => [
            'Adventure Theme Register Section'=>'assets/global/img/section/adventure/register.png',
        ],
        'theme' => 'adventure'
    ],
    'adventure_login' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'submit_button' => 'text',
                'create_account' => 'text',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'submit_button.*' => 'required|max:500',
                'create_account.*' => 'required|max:500',
            ]
        ],
        'image' => [
            'Adventure Theme Section'=>'assets/global/img/section/adventure/login.png',
        ],
        'theme' => 'adventure'
    ],
    'header_top' => [
        'single' => [
            'field_name' => [
                'phone' => 'text',
                'email' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'phone.*' => 'required|max:100',
                'email.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:200',
            ]
        ],
        'multiple' =>[
            'field_name' => [
                'title' => 'text',
                'icon' => 'icon',
                'my_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'icon.*' => 'required',
                'my_link.*' => 'required',
            ]
        ],
        'image' => [
            'Adventure Theme Header Top Section'=>'assets/global/img/section/adventure/header_top.png',
        ],
        'theme' => 'adventure'
    ],


    'holiday' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
            ]
        ],
        'image' => [
            'Adventure Theme Holiday Section'=>'assets/global/img/section/adventure/holiday.png',
        ],
        'theme' => 'adventure'
    ],
    'holiday_two' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
            ]
        ],
        'image' => [
            'Adventure Theme Holiday Second Section'=>'assets/global/img/section/adventure/holiday_two.png',
        ],
        'theme' => 'adventure'
    ],
    'holiday_three' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
            ]
        ],
        'image' => [
            'Adventure Theme Holiday Three Section'=>'assets/global/img/section/adventure/holiday_three.png',
        ],
        'theme' => 'adventure'
    ],
    'account_partials' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'heading_text' => 'text',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'heading_text.*' => 'required|max:100',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'multiple' =>[
            'field_name' => [
                'title' => 'text',
                'icon' => 'icon',
                'my_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'icon.*' => 'required',
                'my_link.*' => 'required',
            ]
        ],
        'image' => [
            'Adventure Theme Account Partial Section'=>'assets/global/img/section/adventure/account_partials.png',
        ],
        'theme' => 'adventure'
    ],
    'destination_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
            ]
        ],
        'image' => [
            'Adventure Theme Destination Two Section'=>'assets/global/img/section/adventure/destination_two.png',
        ],
        'theme' => 'adventure'
    ],

    'popular_tour' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
            ]
        ],
        'image' => [
            'Adventure Theme Popular Tour Section'=>'assets/global/img/section/adventure/popular_tour.png',
        ],
        'theme' => 'adventure'
    ],
    'destination_three' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'button_link.*' => 'required|max:500',
            ]
        ],
        'image' => [
            'adventure Theme Destination Section'=>'assets/global/img/section/adventure/destination_three.png',
        ],
        'theme' => 'adventure'
    ],
    'popular_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Adventure theme Popular Tour Two Section'=>'assets/global/img/section/adventure/popular_two.png',
        ],
        'theme' => 'adventure'
    ],
    'popular_tour_three' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:500',
            ]
        ],
        'image' => [
            'Adventure theme Popular Tour Three Section'=>'assets/global/img/section/adventure/popular_tour_three.png',
        ],
        'theme' => 'adventure'
    ],
    'hero' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'sub_heading_text' => 'text',
                'search_title_one' => 'text',
                'search_title_two' => 'text',
                'video_link' => 'url',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
                'image_four' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'sub_heading_text.*' => 'required|max:100',
                'search_title_one.*' => 'required|max:100',
                'search_title_two.*' => 'required|max:100',
                'video_link.*' => 'required|max:200',
                'button.*' => 'required|max:200',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_four.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Adventure Theme Hero Section'=>'assets/global/img/section/adventure/hero.png',
        ],
        'theme' => 'adventure'
    ],
    'hero_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'sub_heading_text' => 'text',
                'search_title_one' => 'text',
                'search_title_two' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'sub_heading_text.*' => 'required|max:100',
                'search_title_one.*' => 'required|max:100',
                'search_title_two.*' => 'required|max:100',
                'button.*' => 'required|max:200',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:300',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Adventure Theme Second Hero Section'=>'assets/global/img/section/adventure/hero_two.png',
        ],
        'theme' => 'adventure'
    ],
    'hero_three' => [
        'single' => [
            'field_name' => [
                'text_one' => 'text',
                'text_two' => 'text',
                'text_three' => 'text',
                'text_four' => 'text',
                'text_five' => 'text',
                'search_title_one' => 'text',
                'search_title_two' => 'text',
                'button' => 'text',
                'button_two' => 'text',
                'button_link' => 'url',
                'button_link_two' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'text_one.*' => 'required|max:100',
                'text_two.*' => 'required|max:100',
                'text_three.*' => 'required|max:100',
                'text_four.*' => 'required|max:100',
                'text_five.*' => 'required|max:100',
                'search_title_one.*' => 'required|max:100',
                'search_title_two.*' => 'required|max:100',
                'button.*' => 'required|max:200',
                'button_two.*' => 'required|max:200',
                'button_link.*' => 'required|max:200',
                'button_link_two.*' => 'required|max:200',
                'image_three.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png,svg',
            ]
        ],
        'image' => [
            'Adventure Theme Section'=>'assets/global/img/section/adventure/hero_three.png',
        ],
        'theme' => 'adventure'
    ],

    'about' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'description' => 'textarea',
                'button_name'=>'text',
                'button_link'=> 'url',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_name.*' => 'required|max:100',
                'button_link.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'topic' => 'text',
                'description' => 'textarea',
                'button_link' =>'url',
                'image' => 'file',

            ],
            'validation' => [
                'topic.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_link.*' => 'nullable|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Adventure Theme About Section'=>'assets/global/img/section/adventure/about.png',
        ],
        'theme' => 'adventure'
    ],
    'about_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'number' => 'text',
                'text_part_one' => 'text',
                'text_part_two' => 'text',
                'text_part_three' => 'text',
                'sub_heading' => 'text',
                'description' => 'textarea',
                'button_name'=>'text',
                'button_link'=> 'url',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'number.*' => 'required|max:100',
                'text_part_one.*' => 'required|max:100',
                'text_part_two.*' => 'required|max:100',
                'text_part_three.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_name.*' => 'required|max:100',
                'button_link.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'topic' => 'text',
                'description' => 'textarea',
            ],
            'validation' => [
                'topic.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
            ]
        ],
        'image' => [
            'Adventure Theme About Two Section'=>'assets/global/img/section/adventure/about_two.png',
        ],
        'theme' => 'adventure'
    ],
    'about_three' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'description' => 'textarea',
                'button_name'=>'text',
                'button_link'=> 'url',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_name.*' => 'required|max:100',
                'button_link.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'topic' => 'text',
                'description' => 'textarea',
                'button_link' =>'url',
                'image' => 'file',

            ],
            'validation' => [
                'topic.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'button_link.*' => 'nullable|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'image' => [
            'Adventure Theme About Three Section'=>'assets/global/img/section/adventure/about_three.png',
        ],
        'theme' => 'adventure'
    ],
    'feature' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'icon' => 'icon',
                'title' => 'text',
                'sub_title' => 'text',
            ],
            'validation' => [
                'icon.*' => 'required',
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
            ]
        ],
        'image' => [
            'Adventure Theme feature Section'=>'assets/global/img/section/adventure/feature.png',
        ],
        'theme' => 'adventure'
    ],
    'feature_three' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'textarea',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:1000',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'icon' => 'icon',
                'title' => 'text',
                'sub_title' => 'text',
            ],
            'validation' => [
                'icon.*' => 'required',
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:1000',
            ]
        ],
        'image' => [
            'Adventure Theme Feature Section'=>'assets/global/img/section/adventure/feature_three.png',
        ],
        'theme' => 'adventure'
    ],
    'footer' => [
        'single' => [
            'field_name' => [
                'text' => 'text',
                'address' => 'text',
                'phone' => 'text',
                'email' => 'text',
                'card_text' => 'text',
                'destination_package_text' => 'text',
                'copyright' => 'text',
                'copyright_text' => 'text',
                'button_link' => 'url',
                'image' => 'file'
            ],
            'validation' => [
                'text.*' => 'required|max:300',
                'address.*' => 'required|max:300',
                'phone.*' => 'required|max:300',
                'email.*' => 'required|max:300',
                'card_text.*' => 'required|max:300',
                'destination_package_text.*' => 'required|max:300',
                'copyright.*' => 'required|max:300',
                'copyright_text.*' => 'required|max:300',
                'button_link.*' => 'required|max:300',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'icon' => 'icon',
                'button_link' => 'url',
            ],
            'validation' => [
                'icon.*' => 'required',
                'button_link.*' => 'required|max:100',
            ],
        ],
        'image' => [
            'Adventure Theme Footer Section'=>'assets/global/img/section/adventure/footer.png',
            'Relaxation Theme Footer Section'=>'assets/global/img/section/relaxation/footer.png',
        ],
        'theme' => 'all'
    ],


    'card' => [
        'multiple' => [
            'field_name' => [
                'image' => 'file',
            ],
            'validation' => [
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ],
        ],
        'image' => [
            'Relaxation Theme Footer Section'=>'assets/global/img/section/relaxation/card.png',
        ],
        'theme' => 'all'
    ],


    'faq' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'details' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'details.*' => 'required|max:500',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'question' => 'text',
                'answer' => 'text',

            ],
            'validation' => [
                'question.*' => 'required|max:100',
                'answer.*' => 'required|max:500',
            ],
        ],
        'image' => [
            'Adventure Theme Faq Section'=>'assets/global/img/section/adventure/faq.png',
        ],
        'theme' => 'adventure'
    ],
    'blog' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'title' => 'text',
                'sub_title' => 'text',
                'description' => 'text',
                'sub_text' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'description.*' => 'required|max:500',
                'sub_text.*' => 'required',
            ]
        ],
        'image' => [
            'Adventure Theme Blog Section'=>'assets/global/img/section/adventure/blog.png',
        ],
        'theme' => 'adventure'
    ],
    'blog_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'sub_text' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'sub_text.*' => 'required',
            ]
        ],
        'image' => [
            'Adventure Theme Blog Two Section'=>'assets/global/img/section/adventure/blog_two.png',
        ],
        'theme' => 'adventure'
    ],
    'why_chose_us' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'sub_text' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'sub_text.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'details' => 'text',
                'icon' => 'icon',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'details.*' => 'required|max:500',
                'icon.*' => 'required',
            ],
        ],
        'image' => [
            'Adventure Theme Why Chose Us Section'=>'assets/global/img/section/adventure/why_chose_us.png',
        ],
        'theme' => 'adventure'
    ],
    'why_chose_us_two' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'sub_text' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'sub_text.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'details' => 'text',
                'icon' => 'icon',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'details.*' => 'required|max:500',
                'icon.*' => 'required',
            ],
        ],
        'image' => [
            'Adventure Theme Why chose Us Section'=>'assets/global/img/section/adventure/why_chose_us_two.png',
        ],
        'theme' => 'adventure'
    ],
    'why_chose_us_three' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'details' => 'textarea',
                'icon' => 'icon',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'details.*' => 'required|max:2000',
                'icon.*' => 'required',
            ],
        ],
        'image' => [
            'Adventure Theme Why Chose Us Two Section'=>'assets/global/img/section/adventure/why_chose_us_three.png',
        ],
        'theme' => 'adventure'
    ],
    'testimonial'=>[
        'single'=>[
            'field_name'=>[
                'heading' => 'text',
                'sub_heading' => 'text',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:200',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'address' => 'text',
                'description' => 'textarea',
                'image' => 'file',
            ],
            'validation' => [
                'name.*' => 'required|max:100',
                'address.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'image' => [
            'Adventure Theme Testimonial Section'=>'assets/global/img/section/adventure/testimonial.png',
        ],
        'theme' => 'adventure'
    ],
    'testimonial_two'=>[
        'single'=>[
            'field_name'=>[
                'heading' => 'text',
                'sub_heading' => 'text',
                'description' => 'textarea',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:200',
                'description.*' => 'required|max:2000',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'address' => 'text',
                'description' => 'textarea',
                'image' => 'file',
            ],
            'validation' => [
                'name.*' => 'required|max:100',
                'address.*' => 'required|max:100',
                'description.*' => 'required|max:1000',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'image' => [
            'Adventure Theme Testimonial Two Section'=>'assets/global/img/section/adventure/testimonial_two.png',
        ],
        'theme' => 'adventure'
    ],
    'news_letter' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'sub_heading_two' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file'
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'sub_heading_two.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'multiple' => [
            'field_name' => [
                'icon' => 'icon',
                'title' => 'text',
                'value' => 'text',
            ],
            'validation' => [
                'icon.*' => 'required',
                'title.*' => 'required|max:100',
                'value.*' => 'required|max:100',
            ],
        ],
        'image' => [
            'Adventure Theme News Letter Section'=>'assets/global/img/section/adventure/news_letter.png',
        ],
        'theme' => 'adventure'
    ],
    'news_letter_two' => [
        'single' => [
            'field_name' => [
                'section_title' => 'text',
                'section_sub_title' => 'text',
                'section_title_text' => 'textarea',
                'newsletter_title' => 'text',
                'newsletter_text' => 'textarea',
                'button_one_title' => 'text',
                'button_link' => 'url',
                'my_link' => 'url',
                'button_two_title' => 'text',
                'image' => 'file',
                'image_two' => 'file',
            ],
            'validation' => [
                'section_title.*' => 'required|max:100',
                'section_sub_title.*' => 'required|max:100',
                'section_title_text.*' => 'required|max:1000',
                'newsletter_title.*' => 'required|max:100',
                'newsletter_text.*' => 'required|max:1000',
                'button_one_title.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
                'my_link.*' => 'required|max:100',
                'button_two_title.*' => 'required|max:100',
                'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
                'image_two.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
            ]
        ],
        'image' => [
            'Adventure Theme News Letter Two Section'=>'assets/global/img/section/adventure/news_letter_two.png',
        ],
        'theme' => 'adventure'
    ],
    'contact' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'Address' => 'text',
                'Email' => 'text',
                'phone' => 'text',
                'sub_heading' => 'text',
                'heading_two' => 'text',
                'sub_heading_two' => 'text',
                'map' => 'textarea',
                'button' => 'text',
                'button_link' => 'url',

            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'address.*' => 'required|max:300',
                'email.*' => 'required|max:100',
                'phone.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:1000',
                'heading_two.*' => 'required|max:100',
                'sub_heading_two.*' => 'required|max:1000',
                'button.*' => 'required|max:1000',
                'button_link.*' => 'required|max:1000',
                'map.*' => 'required|max:2000',

            ],
        ],
        'multiple' => [
            'field_name' => [
                'icon' => 'icon',
                'title' => 'text',
                'value' => 'text',
            ],
            'validation' => [
                'icon.*' => 'required',
                'title.*' => 'required|max:100',
                'value.*' => 'required|max:100',
            ],
        ],
        'image' => [
            'Adventure Theme Contact Section'=>'assets/global/img/section/adventure/contact.png',
        ],
        'theme' => 'adventure'
    ],

    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => 'This field may not be greater than :max characters.',
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
        'integer' => 'This field must be an integer value',
    ],

    'content_media' => [
        'image' => 'file',
        'image_one' => 'file',
        'image_two' => 'file',
        'image_three' => 'file',
        'image_four' => 'file',
        'image_five' => 'file',
        'image_six' => 'file',
        'image_seven' => 'file',
        'image_eight' => 'file',
        'image_nine' => 'file',
        'image_ten' => 'file',
        'image_eleven' => 'file',
        'thumb_image' => 'file',
        'my_link' => 'url',
        'video_link' => 'url',
        'button_link' => 'url',
        'button_link_two' => 'url',
        'icon' => 'icon',
        'count_number' => 'number',
        'start_date' => 'date'
    ]
];

