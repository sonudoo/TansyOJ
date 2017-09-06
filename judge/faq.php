<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location:../index.php?msg=Please%20login%20first');
}
?>
<?php
    require_once("header.php");
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>
                    FAQ
                </h1>
                <hr>
                <div style="color:gray;width:100%;margin-top:10px;margin-bottom:10px;border-radius:5px;border-style:solid;border-color:gray;padding-left:3%">
                <a href="#q1" data-toggle="collapse" style="text-decoration:none;color:black">
                <p>
                    <h4>Why my solution is not being Accepted?</h4>
                </p>
                </a>
                </div>
                <div id="q1" class="collapse" style="padding-top:20px;padding-left:4%;padding-right:4%;border-style:solid;border-width:1px;border-radius:5px">
                    <p>
                        Here is the list of most common errors along with their cause.<br><br>
                        <ul>
                        <li><b> WA </b><br>
                        <p>
                            Wrong answer is caused by:-
                            <ul>
                                <li>Wrong output being produced by your code. Check your solution again. </li>
                                <li>Printing characters that are not required. Don't print '\n' or extra whitespaces unless specified. Don't print input statements like "Enter the number: " etc. Online judges are not so intelligent and so will give a verdict WA.</li>
                            </ul>

                        </p>
                        </li>
                        <li><b> TLE </b><br>
                        <p>
                            Time Limit Exceeded is caused by:-
                            <ul>
                                <li>Slow solution. Are you running too many loops? Is there a way to reduce the number of instruction? If yes, then your solution is slow and is bound to time out.</li>
                                <li>Waiting for extra I/O than available</li>
                                <li>Taking up large memory spaces than available. The operating system is unable to allocate sufficient space at runtime.</li>
                            </ul>

                        </p>
                        </li>
                        <li><b> NZEC </b><br>
                        <p>
                            Non-zero Exit Code is caused by:-
                            <ul>
                                <li>Trying to access memory location beyond alloted. For example, trying to access 12th memory location in an array of size 10.</li>
                                <li>Division by zero.</li>
                                <li>Taking up large memory spaces than available. The operating system is unable to allocate sufficient space at runtime causing both TLE and NZEC.</li>
                            </ul>

                        </p>
                        </li>
                        <li><b> CE </b><br>
                        <p>
                            Compilation Error is caused by:-
                            <ul>
                                <li>Syntax error. Please make sure that each line of code is correct syntactically. Also static memory allocation is done at compile time. So make sure you are not declaring arrays of large sizes. Check for exact version of compilers and flag used by you and the website. Loadra uses G++ 6.3 as its C/C++ compiler and Java 8 as its Java compiler.</li>
                            </ul>

                        </p>
                        </li>
                    </ul>
                    </p>
                </div>
                <div style="color:gray;width:100%;margin-top:10px;margin-bottom:10px;border-radius:5px;border-style:solid;border-color:gray;padding-left:3%">
                <a href="#q2" data-toggle="collapse" style="text-decoration:none;color:black">
                <p>
                    <h4>Why should I write programs for online judges?</h4>
                </p>
                </a>
                </div>
                <div id="q2" class="collapse" style="padding-top:20px;padding-left:4%;padding-right:4%;border-style:solid;border-width:1px;border-radius:5px">
                    <p>
                        Online judges automatically tests the correctness and efficiency of your code. You don't have to think about writing your own test cases. We have already done this job. You just focus on writing the code. 
                    </p>
                </div>
                <div style="color:gray;width:100%;margin-top:10px;margin-bottom:10px;border-radius:5px;border-style:solid;border-color:gray;padding-left:3%">
                <a href="#q3" data-toggle="collapse" style="text-decoration:none;color:black">
                <p>
                    <h4>What is Competitive Programming?</h4>
                </p>
                </a>
                </div>
                <div id="q3" class="collapse" style="padding-top:20px;padding-left:4%;padding-right:4%;border-style:solid;border-width:1px;border-radius:5px">
                    <p>
                        The question is same as asking "What is cricket?" It's a sport. It's full of fun. Shamlessly quoting directly from Wikipedia: <pre style="white-space:pre-wrap;">Competitive programming is a mind sport usually held over the Internet or a local network, involving participants trying to program according to provided specifications. Contestants are referred to as sport programmers. </pre>
                    </p>
                </div>
                <div style="color:gray;width:100%;margin-top:10px;margin-bottom:10px;border-radius:5px;border-style:solid;border-color:gray;padding-left:3%">
                <a href="#q4" data-toggle="collapse" style="text-decoration:none;color:black">
                <p>
                    <h4>Is Competitive Programming the only way to improve programming skills and get a job?</h4>
                </p>
                </a>
                </div>
                <div id="q4" class="collapse" style="padding-top:20px;padding-left:4%;padding-right:4%;border-style:solid;border-width:1px;border-radius:5px">
                    <p>
                        NO. A big, ugly, freshly baked NO. There are a lot of other things that help in improving programming skills. 
                    </p>
                </div>
                <div style="color:gray;width:100%;margin-top:10px;margin-bottom:10px;border-radius:5px;border-style:solid;border-color:gray;padding-left:3%">
                <a href="#q5" data-toggle="collapse" style="text-decoration:none;color:black">
                <p>
                    <h4>Then why should I do Competitive Programming?</h4>
                </p>
                </a>
                </div>
                <div id="q5" class="collapse" style="padding-top:20px;padding-left:4%;padding-right:4%;border-style:solid;border-width:1px;border-radius:5px">
                    <p>
                        <ul>
                        <li>It's fun. Once you start, you would never get bored of it.</li>
                        <li>It will improve your thinking skills. You will be able to reason out things more rationally. Remember anyone can learn how to program. But only a few can learn how to think.</li>
                        <li>You will start answering questions on StackOverflow instead of asking. Remember the best programmers are known to write their own codes instead of copying others.</li>
                        </ul>
                    </p>
                </div>
        </div>
    </div>
<?php
    require_once("footer.php");
?>
