<?php

class Utilities
{

  //RETURNS TEXT INDICATING THE TIME BETWEEN 2 DATES RANGING FROM SECONDS TO DAYS TO YEARS
  public static function TimeDifference($to_date, $from_date)
  {

    $year_1    = substr($from_date, 0, 4);
    $months_1  = substr($from_date, 5, 2);
    $days_1    = substr($from_date, 8, 2);
    $hours_1   = substr($from_date, 11, 2);
    $minutes_1 = substr($from_date, 14, 2);
    $seconds_1 = substr($from_date, 17, 2);

    $years_2   = substr($to_date, 0, 4);
    $months_2  = substr($to_date, 5, 2);
    $days_2    = substr($to_date, 8, 2);
    $hours_2   = substr($to_date, 11, 2);
    $minutes_2 = substr($to_date, 14, 2);
    $seconds_2 = substr($to_date, 17, 2);

    $universal_time_1 = date('U', mktime($hours_1, $minutes_1, $seconds_1, $months_1, $days_1, $year_1));
    $universal_time_2 = date('U', mktime($hours_2, $minutes_2, $seconds_2, $months_2, $days_2, $years_2));

    //calculate seconds between 2 days
    $calculate_seconds = (int) ($universal_time_1 - $universal_time_2);

    return $calculate_seconds;
  }

  //RETURNS THE WEEKS THAT HAT HAVE ELAPSED FROM GIVEN DATE
  public static function GetWeeksGoneBy($from_date)
  {
    $now = date('Y-m-d H:i:s');

    $calculate_seconds = Utilities::TimeDifference( $from_date,$now);


    //Number of minutes between 2 dates
    $calculate_minutes = (int) ($calculate_seconds / 60);


    //Number of hours between 2 dates
    $calculate_hours = (int) ($calculate_minutes / 60);

    //Number of days between the 2 dates
    $calculate_days = (int) ($calculate_hours / 24);

    //Number of weeks between the 2 dates
    $calculate_weeks = (int) ($calculate_days / 7);

    return $calculate_weeks;
  }

  //RETURNS THE WEEKS THAT HAT HAVE ELAPSED FROM GIVEN DATE
  public static function GetDaysGoneBy($from_date)
  {
    //get the date and time now
    $now = date('Y-m-d H:i:s');

    //Number of seconds between the 2 dates
    $calculate_seconds = Utilities::TimeDifference( $from_date,$now);

    //Number of minutes between 2 dates
    $calculate_minutes = (int) ($calculate_seconds / 60);
    
    //Number of hours between 2 dates
    $calculate_hours = (int) ($calculate_minutes / 60);

    //Number of days between the 2 dates
    $calculate_days = (int) ($calculate_hours / 24);

    return $calculate_days;
  }

  public static function GetYearsGoneBy($from_date)
  {
    //get the date and time now
    $now = date('Y-m-d H:i:s');

    //Number of seconds between the 2 dates
    $calculate_seconds = Utilities::TimeDifference($from_date,$now);

    //Number of minutes between 2 dates
    $calculate_minutes = (int) ($calculate_seconds / 60);

    //Number of hours between 2 dates
    $calculate_hours = (int) ($calculate_minutes / 60);

    //Number of days between the 2 dates
    $calculate_days = (int) ($calculate_hours / 24);

    //Number of weeks between the 2 dates
    $calculate_weeks = (int) ($calculate_days / 7);

    //Number of months between the 2 dates
    $calculate_months = (int) ($calculate_weeks / 4);

    //Number of years between the 2 dates
    $calculate_years = (int) ($calculate_months / 12);

    return $calculate_years;
  }

  //ATTEMPTS TO SEND CONFIRMATION EMAIL
  public static function SendConfirmationEmail($user)
  {
    if ($user == NULL)
    {
      return;
    }
    //send email
    Mail::send('emails.auth.confirmation', array('username' => $user->username, 'id' => $user->id), function($message)use(&$user)
    {
      //attempt to acess the outer var in inner function
      $message->to($user->email, $user->username)->subject('Welcome to the kadic health forum');
    });
  }

}
