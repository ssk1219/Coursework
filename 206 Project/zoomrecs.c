#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include"zoomrecs.h"

//Helper Function
struct ZoomRecord* createZR(char *EM, char *NA, int LN, int DUR) {
	//Create a node
        struct ZoomRecord *myNode = (struct ZoomRecord *) malloc(sizeof(struct ZoomRecord));
        strcpy(myNode->email, EM);
	strcpy(myNode->name, NA);
	for (int i=0; i<9; i++) {
		myNode->durations[i] = 0;
        }//Initialized the array with zero
	myNode->durations[LN] += DUR;
        myNode->next = NULL; //Set as default

	return myNode;
}


//Define addZoomRecord that takes headnode pointer and char array data that represents each line
struct ZoomRecord* addZoomRecord(struct ZoomRecord *headptr, char *data) {
	
	
	//Create variables to store the data
	char myEmail[60];
	char myName[60];
	int myLabNum;
	int myDuration;

	
	//Use strtok to get the email, name, labcode and duration
	char *info;
	info = strtok(data, ",");
	strcpy(myEmail, info);
	info = strtok(NULL, ",");
	strcpy(myName, info);
	info = strtok(NULL, ",");
	//Note that myLabNum represents the index of duration of ZoomRecord
	myLabNum = (int) info[0]-65;
	info = strtok(NULL, ",");
	myDuration = atoi(info);

	//At this point, all data has been stored into variable
	//Now build the linked list
	
	// If head pointer is NULL, create a node and set that to be the head
	if ( headptr == NULL ) {

		//return a headnode
		struct ZoomRecord *newNode = createZR(myEmail, myName, myLabNum, myDuration);
	        return newNode;

	// If head pointer exists but email associated is larger, create a node and set that node to become the head
	} else if ( strcmp(myEmail, headptr->email) < 0 ) {
		
		//return a headnode connecting previous headnode
		struct ZoomRecord *newNode = createZR(myEmail, myName, myLabNum, myDuration);
		newNode->next = headptr;
		return newNode;
	
	// If the email matches, update the record
	} else if ( strcmp(myEmail, headptr->email) == 0) {
		headptr->durations[myLabNum] += myDuration;
		return headptr;

	// If myEmail is larger than the head email, iterate
	} else {
		struct ZoomRecord *prev = headptr;
		struct ZoomRecord *checker = headptr->next;
		
		// While true
		while (1) {
			
			// If End of linked list
			if ( checker == NULL ) {

				struct ZoomRecord *newNode = createZR(myEmail, myName, myLabNum, myDuration);
				prev->next = newNode;
				return headptr;

			// If myEmail is smaller than checker email
			} else if ( strcmp(myEmail, checker->email) < 0 ) {
				
				struct ZoomRecord *newNode = createZR(myEmail, myName, myLabNum, myDuration);
				newNode->next = checker;
				prev->next = newNode;
				return headptr;

			// If myEmail matches with checker email
			} else if ( strcmp(myEmail, checker->email) == 0 ) {
				
				checker->durations[myLabNum] += myDuration;
				return headptr;

			// If neither is the case, update the pointer
			} else {

				prev = prev->next;
				checker = checker->next;
			}
		}
	}
}




void generateAttendance(struct ZoomRecord *headptr, FILE *out) {
	
	// Print the header
	fputs("User Email,Name (Original Name),A,B,C,D,E,F,G,H,I,Attendance (Percentage)\n", out);

	// Iterate through linked list
	struct ZoomRecord *pointer = headptr;
	while (pointer != NULL) {
		
		//Print email and name
		fprintf(out, "%s,", pointer->email);
		fprintf(out, "%s,", pointer->name);

		//Print lab duration while calculate the attendance
		float myAttendance = 0.0;
		for (int i=0; i<9; i++) {

			fprintf(out, "%d,", pointer->durations[i]);

			if (pointer->durations[i] >= 45) {
				myAttendance += 11.11111;
			}
		}

		//fprintf the attendance
		fprintf(out, "%5.2f\n", myAttendance);
	
		//move the pointer
		pointer = pointer->next;
	}

}



