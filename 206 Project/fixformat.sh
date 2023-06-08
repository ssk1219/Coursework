#!/bin/bash

#If two arguments are not recieved, display a usage message and terminate
if [[ ! $# -eq 2 ]]
then
        echo "Usage fixformat.sh <dirname> <opfile>"
        exit 1
fi


#If the first argument is not a vaild directory, throw an error message
myDir=$1
if [[ ! -d "$myDir" ]]
then
        echo "Error "$myDir" is not a valid directory"
        exit 1
fi


#Overwrite the output file with header
outFile=$2
echo 'User Email,Name (Original Name),Lab,Total Duration (Minutes)' > $outFile

#Create a variable called myFile using for-loop that calls any .csv file with given lab file format using find
for myFile in $(find "$myDir" -name '[Ll][Aa][Bb]-[ABCDEFGHIabcdefghi].csv' -type f)
do
	#First, Get the labCode
	fileName=$(basename $myFile)
	labCode=$(echo $fileName | cut -c 5 | tr '[a-i]' '[A-I]')


	#Then, check the format of the lab.csv file by looking for 'Join Time,Leave Time' using grep
	if [[ "$(grep -c 'Join Time,Leave Time' $myFile)" -gt 0 ]]
	then
		#If it is greater than zero, we have to deal with Join Time and Leave Time
		#Use awk to modify the format of CSV file
		awk -v labCode="$labCode" 'BEGIN { FS=","; OFS="," }
		NR>1 { print $2,$1,"LAB#CODE",$5; }' $myFile | sed "s/LAB#CODE/$labCode/" >> $outFile
	else
		#If not, we can ignore the join time and leave time column
		awk -v labCode="$labCode" 'BEGIN { FS=","; OFS="," }
		NR>1 { print $2,$1,"LAB#CODE",$3; }' $myFile | sed "s/LAB#CODE/$labCode/" >> $outFile
	fi
done

#Exit
exit 0
