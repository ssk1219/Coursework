#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include"zoomrecs.h"

int main(int argc, char *argv[]){
	
	//Set head to be an empty node
	struct ZoomRecord *head = NULL;

	//Open the input file
	FILE *readFile = fopen( argv[1], "rt" );
	
	//Read each line
	char line[200];
	fgets(line, sizeof(line), readFile); //Skip the header

	while ( fgets(line, sizeof(line), readFile) != NULL) {
		
		//Call addZoomRecord to create linked list
		head = addZoomRecord(head, line);
	}
	
	//Close read file and open outfile
	fclose(readFile);
	FILE *outFile = fopen( argv[2], "wt" );

	//Call generateAttendance
	generateAttendance(head, outFile);

	//Close outfile
	fclose(outFile);

	//Clean up memory
	struct ZoomRecord *cleaner = head;
	while (cleaner != NULL) {
		struct ZoomRecord *nextUp = cleaner->next;
		free(cleaner);
		cleaner = nextUp;
	}
	return 0;
}
