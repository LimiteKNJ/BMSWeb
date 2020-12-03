use namjunwebdb;

SELECT bmsTitle, bmsSubtitle, bmstableType,
                bmstableNorDiff, bmstableInDiff, bmstableLNInDiff,
                bmsTOTAL, bmsNotes, bmsMD5, bmsMirrorURL, bmsYoutubeURL
                FROM bmsfile, bmstable
                WHERE bmsfile.bmsNo = bmstable.bmstableNo
                and bmsPlayStyle = 2;
                
select * from bmsevent;
select * from bmsfile;
select * from bmstable;
                