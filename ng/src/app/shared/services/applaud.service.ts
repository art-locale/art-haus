// export class ApplaudService {
//
// 	constructor(protected http: HttpClient) {
// 	}
//
// 	//define the API endpoint
// 	private applaudUrl = "api/applaud/";

	//call the Applaud API and create a new applaud
	// import {Applaud} from "../interfaces/applaud";

// call to the Applaud API and get a Applaud object by its foreign key, profile id
getApplaudByApplaudProfileId(applaudProfileId: string) : Observable<Applaud[]> {
	return(this.http.get<Applaud[]>(this.apiUrl + applaudProfileId));
}

// call to the Applaud API and get an Applaud object by its foreign key, image id
getApplaudByApplaudImageId(applaudImageId: string) : Observable<Applaud[]> {
	return(this.http.get<Applaud[]>(this.apiUrl + applaudImageId));
}

// call to the Applaud API and get an Applaud object by its foreign key, image id
getApplaudByApplaudImageIdandApplaudProfileId(applaudProfileId: string, applaudImageId: string) : Observable<Applaud[]> {
	return(this.http.get<Applaud[]>(this.apiUrl + applaudProfileId + applaudImageId));
}
// }