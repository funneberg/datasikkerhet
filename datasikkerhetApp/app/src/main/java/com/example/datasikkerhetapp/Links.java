package com.example.datasikkerhetapp;

public class Links {

    private static final String HTTP = "http://";
    private static final String IP_ADRESS = "158.39.188.221";
    private static final String DIR = "/androidphp/";
    private static final String URL = HTTP+IP_ADRESS+DIR;

    static final String URL_IMG = HTTP+IP_ADRESS+"/bilder/";

    static final String URL_LOGIN = URL+"/login.php";
    static final String URL_REGISTER = URL+"/register.php";
    static final String URL_CHANGE_PASSWORD = URL+"/changepassword.php";
    static final String URL_REPORT_INQUIRY = URL+"/reportinquiry.php";
    static final String URL_REPORT_COMMENT = URL+"/reportcomment.php";
    static final String URL_SEND_INQUIRY = URL+"/sendinquiry.php";
    static final String URL_SEND_COMMENT = URL+"/comment.php";
    static final String URL_GET_COURSES= URL+"/getcourses.php";
    static final String URL_GET_COMMENTS = URL+"/getcomments.php?coursecode=";

}
