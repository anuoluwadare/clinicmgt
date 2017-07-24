<?php
//class for generating date combos
//not really my code
//
class date_pulldown {
    var $name;
    var $timestamp = -1;
    var $months = array("01", "02", "03", "04", "05", "06",
    "07", "08", "09", "10", "11", "12");
     var $yearstart = -1;
     var $yearend = -1;


   function date_pulldown($name) {
       $this->name = $name;
   }
function setDate_global( ) {
   if (!@$this->setDate_array($GLOBALS[$this->name])) {
            return $this->setDate_timestamp(time());
        }
        return true;
    }

    function setDate_timestamp($time) {
     $this->timestamp = $time;
        return true;

    }



    function setDate_array($inputdate) {

        if (is_array($inputdate) &&
            isset($inputdate['mon']) &&
            isset($inputdate['mday']) &&
            isset($inputdate['year'])) {
            $this->timestamp = mktime(11, 59, 59,
                $inputdate['mon'], $inputdate['mday'], $inputdate['year']);
            return true;
        }
        return false;
   }
function setYearStart($year) {
        $this->yearstart = $year;
    }

    function setYearEnd($year) {
        $this->yearend = $year;
  }

function getYearStart() {
     if ($this->yearstart < 0) {
           $nowarray = getdate(time());
           @$this->yearstart = $nowarray[year]-5;
      }
      return $this->yearstart;

  }
function getYearEnd() {
      if ($this->yearend < 0) {
          $nowarray = getdate(time());
           @$this->yearend = $nowarray[year]+5;
      }
     return $this->yearend;
 }

function output() {
       if ($this->timestamp < 0) {
            $this->setDate_global();
        }
        $datearray = getdate($this->timestamp);
		$out = $this->year_select($this->name, $datearray);
		$out .= $this->month_select($this->name, $datearray);
        $out .= $this->day_select($this->name, $datearray);
        
     
        return $out;
   }

function day_select($fieldname, $datearray)  {
       $out = "<select class=\"date_rpt\" name=\"$fieldname"."[mday]\">\n";
       for ($x=1; $x<=31; $x++) {
       $out .= "<option value=\"$x\"".($datearray['mday']==($x)
      ?" SELECTED":"").">".sprintf("%02d", $x ) ."\n";
		 }
      $out .= "</select>\n";
      return $out;
    }

    function month_select($fieldname, $datearray) {
        $out = "<select class=\"date_rpt\" name=\"$fieldname"."[mon]\">\n";
        for ($x = 1; $x <= 12; $x++) {
          $out .= "<option value=\"".($x)."\"".($datearray['mon']==($x)
               ?" SELECTED":"")."> ".$this->months[$x-1]."\n";
        }
       $out .= "</select>\n";
       return $out;
    }

   function year_select($fieldname, $datearray) {
       $out = "<select class=\"date_rpt\" name=\"$fieldname"."[year]\">";
       $start = $this->getYearStart();
        $end = $this->getYearEnd();
       for ($x= $start; $x < $end; $x++) {
            $out .= "<option value=\"$x\"".($datearray['year']==($x)
               ?" SELECTED":"").">$x\n";
        }
        $out .= "</select>\n";
        return $out;
    }
 }

   
   
?>