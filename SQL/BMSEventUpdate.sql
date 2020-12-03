use namjunwebdb;

select * from bmsevent;
insert into bmsevent (eventbmsEvent, eventbmsName, eventbmsURL,
					 eventbmsSPBeginner, eventbmsSPNormal, eventbmsSPHyper, eventbmsSPAnother, eventbmsSPInsane,
                     eventbmsDPNormal, eventbmsDPHyper, eventbmsDPAnother, eventbmsDPInsane)
			value ("", "", "http://",
					"","","","","","","","","");
