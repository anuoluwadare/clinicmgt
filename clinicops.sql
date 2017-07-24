/*
MySQL Backup
Source Host:           localhost
Source Server Version: 5.0.17-nt
Source Database:       clinicops
Date:                  2006/05/22 17:34:20
*/

SET FOREIGN_KEY_CHECKS=0;
use clinicops;
#----------------------------
# Table structure for actingroles
#----------------------------
CREATE TABLE `actingroles` (
  `entryid` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `rolename` varchar(100) NOT NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB';
#----------------------------
# Records for table actingroles
#----------------------------


insert  into actingroles values 
(1, 'lightwave', 'admin'), 
(2, 'nursebola', 'nurse'), 
(3, 'nursebola', 'pharm'), 
(4, 'doctorayeni', 'doctor'), 
(5, 'doctorayeni', 'admin'), 
(6, 'pharmayo', 'pharm');
#----------------------------
# Table structure for appointment
#----------------------------
CREATE TABLE `appointment` (
  `entryid` int(11) NOT NULL auto_increment,
  `cliniccallid` varchar(255) NOT NULL,
  `patientid` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time default NULL,
  `doctortosee` varchar(255) NOT NULL,
  `comment` text,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 3072 kB; InnoDB free: 4096 kB';
#----------------------------
# Records for table appointment
#----------------------------


insert  into appointment values 
(3, '1', '0002', '2006-05-23', null, 'doctorayeni', '');
#----------------------------
# Table structure for cliniccall
#----------------------------
CREATE TABLE `cliniccall` (
  `entryid` int(11) NOT NULL auto_increment,
  `timein` time NOT NULL,
  `patientid` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `userid` varchar(255) NOT NULL,
  `visitticket` varchar(255) default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB';
#----------------------------
# Records for table cliniccall
#----------------------------


insert  into cliniccall values 
(1, '14:54:56', '0002', '2006-05-19', '14:56:22', 'nursebola', '1148043382');
#----------------------------
# Table structure for dispensaryvisit
#----------------------------
CREATE TABLE `dispensaryvisit` (
  `entryid` int(11) NOT NULL auto_increment,
  `patientid` varchar(255) default NULL,
  `userid` varchar(255) default NULL,
  `comment` text,
  `cliniccallid` varchar(255) default NULL,
  `date` date default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
#----------------------------
# Records for table dispensaryvisit
#----------------------------


insert  into dispensaryvisit values 
(1, '0002', 'pharmayo', 'ok', '1', '2006-05-19'), 
(2, '0002', 'pharmayo', 'fg hhhfgfg  rtu  uy ytttr ', '1', '2006-05-22'), 
(3, '0002', 'pharmayo', 'thrrrhhrh tytr tty tyty ty trtyy45 ', '1', '2006-05-22');
#----------------------------
# Table structure for druggroups
#----------------------------
CREATE TABLE `druggroups` (
  `entryid` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `comment` text,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB';
#----------------------------
# Records for table druggroups
#----------------------------


insert  into druggroups values 
(1, 'Antimalarials', 'used in treating some mosquito diseases'), 
(2, 'Antibiotics', 'dw jkff ww ew ewthg ewjgwefj jyewewte ewutefw ewfeee'), 
(3, 'Retrovirals', 'ggr gjhgbvh kg ');
#----------------------------
# Table structure for drugstore
#----------------------------
CREATE TABLE `drugstore` (
  `entryid` int(11) NOT NULL auto_increment,
  `drugcode` varchar(100) NOT NULL default '',
  `drugname` varchar(100) NOT NULL,
  `druggroup` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `unitmeasure` varchar(100) NOT NULL,
  `qtyinstock` int(11) NOT NULL,
  `dosage` varchar(100) default NULL,
  `reorderlevel` int(11) NOT NULL,
  `dispensemode` varchar(100) NOT NULL,
  PRIMARY KEY  (`entryid`,`drugcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
#----------------------------
# Records for table drugstore
#----------------------------


insert  into drugstore values 
(1, 'RFT', 'halfan', 'Antimalarials', 'adhwf kjwh uw wtu efwjhghgwe            ', 'Boxed Capsules', 5374, 'see leaflet', 100, 'Prescription'), 
(2, 'PEN', 'Penincillin', 'Antimalarials', 'adhwf kjwh uw wtu efwjhghgwe            ', 'Boxed Capsules', 1360, 'see leaflet', 200, 'Prescription'), 
(3, 'RFT', 'Fansidar', 'Antimalarials', 'adhwf kjwh uw wtu efwjhghgwe                                    ', 'tablets', 5152, 'see leaflet', 400, 'Prescription'), 
(13, 'UJH', 'Underwood', 'Antibiotics', '  jew ewg ewy ewy eywf ew tyfew eytwf rewe          ', 'ampoules', 290, 'see leaflet', 10, 'Request'), 
(14, 'FLAV', 'FLAV101', 'Retrovirals', '   ghf ghgh gggf fgfghg   gfgggf                                 ', 'ampoules', 4917, 'see packaging', 100, 'Prescription');
#----------------------------
# Table structure for hospitals
#----------------------------
CREATE TABLE `hospitals` (
  `entryid` int(11) NOT NULL auto_increment,
  `hospital` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `comments` text,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
#----------------------------
# Records for table hospitals
#----------------------------


insert  into hospitals values 
(1, 'St Mary\'s memorial hospital', 'Gwalahn d eutye eyte ehbh uyge', null);
#----------------------------
# Table structure for mstatus
#----------------------------
CREATE TABLE `mstatus` (
  `entryid` int(11) NOT NULL auto_increment,
  `mstatus` varchar(100) default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# Records for table mstatus
#----------------------------


insert  into mstatus values 
(1, 'married'), 
(2, 'single');
#----------------------------
# Table structure for otherdrugs
#----------------------------
CREATE TABLE `otherdrugs` (
  `sid` int(11) NOT NULL auto_increment,
  `callid` int(11) default NULL,
  `patientid` int(11) default NULL,
  `drugname` varchar(100) default NULL,
  `qty` varchar(100) default NULL,
  `unit` varchar(100) default NULL,
  `dosage` varchar(100) default NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# Records for table otherdrugs
#----------------------------


insert  into otherdrugs values 
(1, 1, 2, 'tyyryr', '45', 'fhhhg', 'hghghhgh');
#----------------------------
# Table structure for patients
#----------------------------
CREATE TABLE `patients` (
  `entryid` int(11) NOT NULL,
  `patientid` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `othername` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `employeetype` varchar(30) NOT NULL,
  `employeeid` varchar(20) NOT NULL,
  `dept` varchar(40) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `mstatus` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `nokname` varchar(100) NOT NULL,
  `nocaddress` varchar(100) NOT NULL,
  `nocphone` varchar(50) NOT NULL,
  PRIMARY KEY  (`entryid`,`patientid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 3072 kB; InnoDB free: 3072 kB; InnoDB free: 307';
#----------------------------
# Records for table patients
#----------------------------


insert  into patients values 
(0, '00001', 'opeyemi', 'titilayo', 'adeola', 'permanent', 'FLT009', 'FLEET', 'female', 'married', '0809657656', '1971-05-17', 'no 12 pipson drive mayson', 'Mr udson', 'no 12 pipson drive mayson', '67898787'), 
(0, '0002', 'opeyemi', 'titilayo', 'adeola', 'permanent', 'FLT009', 'FLEET', 'female', 'married', '0809657656', '1971-05-17', 'no 12 pipson drive mayson', 'Mr udson', 'no 12 pipson drive mayson', '67898787');
#----------------------------
# Table structure for prescription
#----------------------------
CREATE TABLE `prescription` (
  `entryid` int(11) NOT NULL auto_increment,
  `dispenseid` varchar(255) default NULL,
  `drugcode` varchar(255) default NULL,
  `qtydispensed` int(11) default NULL,
  `dosage` varchar(255) default NULL,
  `dispensemode` varchar(255) default NULL,
  `dispensarystate` varchar(255) default NULL,
  `patientid` varchar(255) default NULL,
  `cliniccallid` varchar(255) default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
#----------------------------
# Records for table prescription
#----------------------------


insert  into prescription values 
(1, '1', '1', 12, '2 tabs 3 times daily', 'prescription', 'dispensed', '0002', '1'), 
(2, '1', '2', 20, '3 tabs 2 times daily', 'prescription', 'dispensed', '0002', '1'), 
(3, '1', '3', 7, '2 tabs 3 times daily', 'prescription', 'dispensed', '0002', '1'), 
(4, '2', '1', 6, '2 tabs 3 times daily', 'prescription', 'dispensed', '0002', '1'), 
(5, '2', '3', 12, '3 tabs 2 times daily', 'prescription', 'notavailable', '0002', '1'), 
(6, '2', '14', 67, '2 tabs 3 times daily', 'prescription', 'dispensed', '0002', '1'), 
(7, '3', '1', 5, '2 tabs 3 times daily', 'prescription', 'dispensed', '0002', '1'), 
(8, '3', '3', 7, '3 tabs 2 times daily', 'prescription', 'dispensed', '0002', '1'), 
(9, '3', '14', 8, '2 tabs 3 times daily', 'prescription', 'dispensed', '0002', '1');
#----------------------------
# Table structure for referrals
#----------------------------
CREATE TABLE `referrals` (
  `entryid` int(11) NOT NULL auto_increment,
  `patientid` varchar(255) default NULL,
  `cliniccallid` varchar(255) default NULL,
  `hospital` varchar(255) default NULL,
  `userid` varchar(255) default NULL,
  `comment` text,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
#----------------------------
# Records for table referrals
#----------------------------


insert  into referrals values 
(1, '0002', '1', '1', 'doctorayeni', ''), 
(2, '0002', '1', '1', 'doctorayeni', '');
#----------------------------
# Table structure for treatment
#----------------------------
CREATE TABLE `treatment` (
  `entryid` int(11) NOT NULL auto_increment,
  `cliniccallid` varchar(255) default NULL,
  `patientid` varchar(255) default NULL,
  `complaint` text,
  `treatment` text,
  `diagnosis` text,
  `doctor` varchar(255) default NULL,
  `date` date default NULL,
  `time` time default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB; InnoDB free: 3072 kB';
#----------------------------
# Records for table treatment
#----------------------------


insert  into treatment values 
(1, '1', '0002', 'ei eruiy euier eruit  ee teuer eyr teut', ' ugruit tuirettr reuerjgjhgtr jer', 'ytef euyt r eywt qt erd ds bdsf ewurerre', 'doctorayeni', '2006-05-19', '14:57:58');
#----------------------------
# Table structure for treatmentstatus
#----------------------------
CREATE TABLE `treatmentstatus` (
  `entryid` int(11) NOT NULL auto_increment,
  `patientid` varchar(255) default NULL,
  `status` varchar(255) default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
#----------------------------
# Records for table treatmentstatus
#----------------------------


insert  into treatmentstatus values 
(1, '0002', 'INCOMPLETE');
#----------------------------
# Table structure for users
#----------------------------
CREATE TABLE `users` (
  `entryid` int(11) NOT NULL auto_increment,
  `username` varchar(100) default NULL,
  `password` varchar(100) default NULL,
  `jobdesc` varchar(100) default NULL,
  `fullname` varchar(100) default NULL,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB';
#----------------------------
# Records for table users
#----------------------------


insert  into users values 
(1, 'doctorayeni', 'doctorayeni', 'doctor', 'Dr Ayeni Oluyele'), 
(2, 'lightwave', 'lightwave', 'admin', 'Olapade adeleye'), 
(3, 'nursebola', 'password', 'nurse', 'Adebola Adeleye'), 
(4, 'pharmayo', 'pharmayo', 'pharm', 'pharm Ayodele Awe'), 
(5, 'superuser', 'password', 'admin', 'Mr Odekunle Adeleke');
#----------------------------
# Table structure for vitals
#----------------------------
CREATE TABLE `vitals` (
  `entryid` int(11) NOT NULL auto_increment,
  `cliniccallid` varchar(11) default NULL,
  `patientid` varchar(255) default NULL,
  `temperature` varchar(10) default NULL,
  `bloodpressure` varchar(10) default NULL,
  `pulserate` varchar(10) default NULL,
  `userid` varchar(40) default NULL,
  `comments` text,
  PRIMARY KEY  (`entryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB; InnoDB free: 4096 kB';
#----------------------------
# Records for table vitals
#----------------------------


insert  into vitals values 
(1, '1', '0002', '56', '567', '456', 'nursebola', 'y nuiui uiyi  yi oo  ioioiio');

