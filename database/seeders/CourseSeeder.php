<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\AssessmentOption;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course1 = new Course(
            [
                'name' => 'Advanced Javascript',
                'code' => 'ITEC-111',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquam quam non enim rutrum, id ornare urna dignissim. Praesent suscipit malesuada ipsum, ac commodo mauris eleifend quis. Phasellus varius et diam vitae lacinia. Vivamus turpis dui, interdum in pharetra sed, porta sit amet lorem. Nulla bibendum dui eu pellentesque pretium',
                'created_by' => 1,
                'status' => 1,
                'slug' => Str::slug('Advanced Javascript')
            ]
        );
        $course1->save();

        $topics = [
            [
                'title' => 'Understanding Closures in JavaScript',
                'content' => 'Closures are a fundamental concept in JavaScript that allows functions to retain access to variables from their containing scope, even after the parent function has finished executing. When a function is defined inside another function, it creates a closure. This enables the inner function to access variables and parameters of the outer function, even after the outer function has returned.
                
                One common use case of closures is in event handlers. In event-driven programming, callbacks are often used to handle events such as button clicks or form submissions. Closures provide a way to maintain the state of the surrounding context within these callback functions, allowing them to access variables and data from the enclosing scope.
                
                Understanding closures is crucial for writing clean and efficient code in JavaScript. They play a significant role in modern JavaScript development, especially in scenarios where you need to create functions with private data or maintain state across multiple function calls.',
            ],
            [
                'title' => 'Exploring Prototypes and Prototypal Inheritance',
                'content' => 'Prototypes and prototypal inheritance are core concepts in JavaScript\'s object-oriented programming model. Unlike class-based inheritance in languages like Java or C++, JavaScript uses prototypes to implement inheritance between objects. Every JavaScript object has a prototype, which serves as a template for properties and methods that the object inherits.
                
                Understanding prototypes is essential for grasping how inheritance works in JavaScript. When you access a property or method on an object, JavaScript first checks if the object itself has that property or method. If not, it looks up the prototype chain to find the property or method in the object\'s prototype and its ancestors.
                
                Prototypal inheritance allows for dynamic object creation and modification, making JavaScript a highly flexible and expressive language. By leveraging prototypes, developers can create reusable and extensible code that promotes code reuse and modularity.',
            ],
            [
                'title' => 'Asynchronous JavaScript: Callbacks, Promises, and Async/Await',
                'content' => 'Asynchronous programming is a key aspect of modern JavaScript development, enabling non-blocking execution of code and better handling of tasks such as network requests, file I/O, and user interactions. JavaScript provides several mechanisms for working with asynchronous code, including callbacks, promises, and the async/await syntax.
                
                Callbacks were the traditional way of handling asynchronous operations in JavaScript. However, they often led to callback hell, where nested callbacks made the code difficult to read and maintain. Promises introduced in ES6 provide a cleaner and more structured way to handle asynchronous operations, allowing chaining of then() methods to handle success and catch() method to handle errors.
                
                The async/await syntax, introduced in ES8, builds on top of promises and provides a more synchronous way of writing asynchronous code. Async functions return a promise, allowing you to use await keyword to pause execution until the promise is resolved or rejected. This syntax greatly improves code readability and makes working with asynchronous code in JavaScript more intuitive.',
            ],
        ];

        foreach ($topics as  $topic) {
            Topic::create([
                'title' => $topic['title'],
                'slug' => Str::slug($topic['title'], '-'),
                'content' => $topic['content'],
                'status' => 1,
                'created_by' => 1,
                'course_id' => 1,
            ]);
        }

        $assessment = Assessment::create([
            'title' => 'Quiz 1',
            'instruction' => 'Select the letter of the choice the best describes the question',
            'after_topic_id' => 1,
            'course_id' => 1,
            'type' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        AssessmentOption::create([
            'assessment_id' => 1,
            'question' => 'Which of the following terms refers to a collection of elements of the same data type that are stored in contiguous memory locations?',
            'option_a' => 'Array',
            'option_b' => 'Object',
            'option_c' => 'Set',
            'option_d' => 'Dictionary',
            'answer' => 1,
        ]);

        AssessmentOption::create([
            'assessment_id' => 1,
            'question' => 'Which statement is used to handle exceptions in JavaScript?',
            'option_a' => 'switch',
            'option_b' => 'throw',
            'option_c' => 'catch-finally',
            'option_d' => 'try-catch',
            'answer' => 4,
        ]);

        AssessmentOption::create([
            'assessment_id' => 1,
            'question' => 'In JavaScript, which keyword is used to prevent the reassignment of a variable?',
            'option_a' => 'var',
            'option_b' => 'const',
            'option_c' => 'final',
            'option_d' => 'static',
            'answer' => 2,
        ]);

        AssessmentOption::create([
            'assessment_id' => 1,
            'question' => 'Which JavaScript method is used to convert a number to a string representation?',
            'option_a' => 'toNumber()',
            'option_b' => 'parseFloat()',
            'option_c' => 'toString()',
            'option_d' => 'valueOf()',
            'answer' => 3,
        ]);

        AssessmentOption::create([
            'assessment_id' => 1,
            'question' => 'Which method is used to combine all elements of an array into a string in JavaScript?',
            'option_a' => 'concat()',
            'option_b' => 'splice()',
            'option_c' => 'reduce()',
            'option_d' => 'join()',
            'answer' => 4,
        ]);

        $course2 = new Course(
            [
                'name' => 'Introduction to HTML5',
                'code' => 'ITEC-50',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquam quam non enim rutrum, id ornare urna dignissim. Praesent suscipit malesuada ipsum, ac commodo mauris eleifend quis. Phasellus varius et diam vitae lacinia. Vivamus turpis dui, interdum in pharetra sed, porta sit amet lorem. Nulla bibendum dui eu pellentesque pretium',
                'created_by' => 1,
                'status' => 1,

                'slug' => Str::slug('Introduction to HTML5')
            ]
        );
        $course2->save();

        $course2Topics = [
            [
                'title' => 'Understanding the Basics of HTML 5',
                'content' => "HTML 5, or Hypertext Markup Language 5, is the latest iteration of the HTML standard, which serves as the backbone of web development. It provides structure to web pages by utilizing a markup system consisting of tags enclosed in angle brackets. These tags define various elements of a webpage, such as headings, paragraphs, images, and links. Understanding the basic syntax of HTML 5 is crucial for anyone aspiring to develop web content, as it forms the foundation upon which all web pages are built. With HTML 5, developers have access to a wide range of new features and elements, making it more powerful and versatile than its predecessors.
                        As you delve into HTML 5, you'll encounter a variety of tags and attributes that allow you to create dynamic and interactive web experiences. From simple text formatting with tags like <strong> and <em> to more complex structures like tables, forms, and multimedia elements, HTML 5 offers a comprehensive toolkit for web development. By mastering these fundamentals, you'll be able to create well-structured and visually appealing web pages that meet the needs of both users and search engines.
                        Furthermore, HTML 5 introduces semantic elements that provide meaning to the content they enclose, enhancing accessibility and search engine optimization. These semantic elements, such as <header>, <nav>, <section>, <article>, <aside>, and <footer>, describe the purpose of the content, making it easier to understand and navigate. Embracing semantic markup is essential for modern web development practices, as it promotes better organization and clarity in code, ultimately leading to more maintainable and scalable web projects. By incorporating semantic elements into your HTML 5 documents, you'll not only improve the structure and accessibility of your web pages but also contribute to the overall user experience.
                        ",
            ],
            [
                'title' => 'Exploring HTML 5 Semantic Elements',
                'content' => "HTML 5 introduces a set of semantic elements that provide meaning to the content they enclose, revolutionizing the way we structure web pages. Unlike traditional div-based layouts, these semantic elements describe the purpose of the content, enhancing accessibility and search engine optimization. For instance, the <header> element defines introductory content at the beginning of a section or webpage, while the <nav> element represents a section of navigation links. Similarly, the <section> and <article> elements help organize content into meaningful sections, improving readability and comprehension for both users and web crawlers.
In addition to improving the structure and accessibility of web pages, semantic elements also contribute to better code organization and maintenance. By using semantic markup, developers can create cleaner and more maintainable HTML documents, making it easier to collaborate with team members and update existing codebases. Furthermore, semantic elements play a crucial role in responsive web design, allowing developers to create layouts that adapt seamlessly to different screen sizes and devices. Embracing semantic markup is essential for modern web development practices, as it promotes better organization and clarity in code, ultimately leading to more maintainable and scalable web projects.",
            ],
            [
                'title' => 'Harnessing the Power of HTML 5 Multimedia',
                'content' => "One of the most exciting features of HTML 5 is its native support for multimedia content, which allows developers to embed audio and video elements directly into web pages using simple tags like <audio> and <video>. This eliminates the need for third-party plugins like Adobe Flash, ensuring better compatibility across different devices and browsers. HTML 5 offers advanced capabilities for handling multimedia, such as controlling playback, adding subtitles, and providing fallback content for older browsers. By leveraging HTML 5 multimedia features, developers can enrich their web pages with engaging audiovisual content, enhancing the overall user experience.
Moreover, HTML 5 multimedia elements provide developers with greater flexibility and control over how multimedia content is presented and accessed on the web. With support for various multimedia formats and codecs, developers can choose the best options based on factors such as file size, quality, and compatibility. Additionally, HTML 5 multimedia features are highly customizable, allowing developers to define custom controls, styling, and behaviors to suit their specific needs. By harnessing the power of HTML 5 multimedia, developers can create immersive and interactive web experiences that captivate audiences and deliver information in compelling ways.",
            ],
        ];

        foreach ($course2Topics as  $topic) {
            Topic::create([
                'title' => $topic['title'],
                'slug' => Str::slug($topic['title'], '-'),
                'content' => $topic['content'],
                'status' => 1,
                'created_by' => 1,
                'course_id' => 2,
            ]);
        }


        $course3 = new Course(
            [
                'name' => 'Computer Programming 1',
                'code' => 'DCIT-22',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquam quam non enim rutrum, id ornare urna dignissim. Praesent suscipit malesuada ipsum, ac commodo mauris eleifend quis. Phasellus varius et diam vitae lacinia. Vivamus turpis dui, interdum in pharetra sed, porta sit amet lorem. Nulla bibendum dui eu pellentesque pretium',
                'created_by' => 1,
                'status' => 1,

                'slug' => Str::slug('Computer Programming 1')
            ]
        );
        $course3->save();

        $course3Topics = [
            [
                'title' => 'The Foundations of Programming',
                'content' => 'Understanding the Basics: Introduce students to the fundamental concepts of computer programming, including variables, data types, operators, and control structures (such as loops and conditionals). Emphasize the importance of syntax and logic in writing effective code.
                             Hands-On Practice: Provide hands-on coding exercises using a beginner-friendly language like Python. Encourage students to experiment with writing simple programs to reinforce their understanding of the core concepts covered in the lesson.
                             Real-World Applications: Discuss real-world examples of how programming is used in various industries, from web development to artificial intelligence. Highlight the versatility of programming skills and the potential career opportunities available to those proficient in coding.',
            ],
            [
                'title' => 'Problem-Solving with Algorithms',
                'content' => 'Introduction to Algorithms: Introduce students to the concept of algorithms as step-by-step procedures for solving problems. Discuss different types of algorithms, such as sorting and searching, and their relevance in computer science.
                              Algorithm Design: Teach students how to design and analyze algorithms using techniques such as pseudocode and flowcharts. Emphasize the importance of algorithm efficiency and how to measure it using Big O notation.
                              Practical Applications: Illustrate how algorithms are applied in everyday scenarios, such as optimizing travel routes, recommending products, or processing large datasets. Engage students in interactive activities to solve problems using algorithmic thinking.',
            ],
            [
                'title' => 'Introduction to Object-Oriented Programming (OOP)',
                'content' => 'Understanding OOP Concepts: Introduce students to the principles of object-oriented programming, including classes, objects, inheritance, encapsulation, and polymorphism. Explain how OOP enables modular, reusable, and scalable code.
                              Implementation in Practice: Guide students through the process of designing and implementing classes in a programming language like Java or C++. Provide examples of real-world objects and demonstrate how they can be modeled using classes and objects.
                              Project-Based Learning: Encourage students to apply their knowledge of OOP principles to create their own projects, such as building a simple game or designing a digital inventory system. Foster creativity and problem-solving skills through hands-on coding projects.',
            ],
        ];

        foreach ($course3Topics as  $topic) {
            Topic::create([
                'title' => $topic['title'],
                'slug' => Str::slug($topic['title'], '-'),
                'content' => $topic['content'],
                'status' => 1,
                'created_by' => 1,
                'course_id' => 3,
            ]);
        }

        $course4 = new Course(
            [
                'name' => 'Introduction to Computing',
                'code' => 'DCIT-21',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquam quam non enim rutrum, id ornare urna dignissim. Praesent suscipit malesuada ipsum, ac commodo mauris eleifend quis. Phasellus varius et diam vitae lacinia. Vivamus turpis dui, interdum in pharetra sed, porta sit amet lorem. Nulla bibendum dui eu pellentesque pretium',
                'created_by' => 1,
                'status' => 1,

                'slug' => Str::slug('Introduction to Computing')
            ]
        );
        $course4->save();

        $course4Topics = [
            [
                'title' => 'Foundations of Computing',
                'content' => 'Computing forms the backbone of modern technology, encompassing a broad range of concepts and principles that drive innovation and advancement. At its core, computing involves the processing of data using algorithms and logical instructions to solve problems and perform tasks. Understanding the foundational concepts of computing is essential for anyone interested in technology, as it provides the necessary framework for exploring more advanced topics. Key concepts include binary representation, which underpins all digital data storage and manipulation, as well as algorithms, which are step-by-step procedures for solving problems. By grasping these fundamental concepts, learners can develop a solid understanding of how computers work and how they can be utilized to tackle real-world challenges.',
            ],
            [
                'title' => 'Introduction to Programming',
                'content' => 'Programming lies at the heart of computing, enabling developers to create software applications that automate tasks, process data, and interact with users. Learning to program involves mastering a programming language, such as Python, Java, or JavaScript, and understanding the principles of software development. This includes concepts such as variables, data types, control structures, and functions, which form the building blocks of programs. Through hands-on practice and experimentation, learners can develop their programming skills and gain the ability to write code to solve problems and implement solutions. Moreover, programming fosters critical thinking, problem-solving, and creativity, making it a valuable skill in various fields beyond computing.',
            ],
            [
                'title' => 'Exploring Computer Networks and the Internet',
                'content' => 'Computer networks play a crucial role in connecting devices and facilitating communication and resource sharing. Understanding how computer networks function is essential for navigating the digital landscape effectively. This includes concepts such as protocols, which define the rules and conventions for communication between devices, and network topologies, which describe the physical or logical arrangement of network components. Additionally, the Internet, a global network of interconnected computers, has revolutionized the way information is accessed and shared, shaping the modern world in profound ways. Exploring computer networks and the Internet provides insights into how data travels across networks, the role of network security, and the implications of networked technologies on society. By gaining a deeper understanding of computer networks and the Internet, learners can harness the power of connectivity to innovate, collaborate, and create positive change in the world.',
            ],
        ];

        foreach ($course4Topics as  $topic) {
            Topic::create([
                'title' => $topic['title'],
                'slug' => Str::slug($topic['title'], '-'),
                'content' => $topic['content'],
                'status' => 1,
                'created_by' => 1,
                'course_id' => 4,
            ]);
        }

        $assessment2 = Assessment::create([
            'title' => 'Project - Tic Tac Toe',
            'instruction' => 'Create the program, Tic-Tac-Toe using JavaScript. Deadline is on June 25, 2024. The program should implement all the topics on this course',
            'after_topic_id' => 3,
            'course_id' => 1,
            'type' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);
    }
}
