#!/bin/bash

#Set input and output destination
input=$1
output=$2

#Echo table
echo "<TABLE>" > $output

#Use sed
#First, insert <TR><TD> at the start of the line
#Second, replace all comma by </TD><TD>
#Third, append </TD></TR> at the end of the line
sed -e 's|^|<TR><TD>|' -e 's|,|</TD><TD>|g' -e 's|$|</TD></TR>|' $input >> $output

#Echo endtable
echo "</TABLE>" >> $output

exit 0
