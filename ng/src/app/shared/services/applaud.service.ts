import {Injectable} from "@angular/core";
import {Applaud} from "../interfaces/applaud";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApplaudService {

constructor(protected http : HttpClient ) {}

//define the API endpoint
private applaudUrl = "https://bootcamp-coders.cnm.edu/~bhuffman1/art-haus/public_html/api/applaud/";

// call to the Applaud API and create the applaud in question
createApplaud(applaud : Applaud) : Observable<Status> {
return(this.http.post<Status>(this.applaudUrl, applaud));
}

// call to the Applaud API and get a Applaud object by its foreign key, profile id
getApplaudByApplaudProfileId(applaudProfileId: string) : Observable<Applaud[]> {
return(this.http.get<Applaud[]>(this.applaudUrl + applaudProfileId));
}

// call to the Applaud API and get an Applaud object by its foreign key, image id
getApplaudByApplaudImageId(applaudImageId: string) : Observable<Applaud[]> {
return(this.http.get<Applaud[]>(this.applaudUrl + applaudImageId));
}

// call to the Applaud API and get an Applaud object by its foreign key, image id
getApplaudByApplaudImageIdandApplaudProfileId(applaudProfileId: string, applaudImageId: string) : Observable<Applaud[]> {
return(this.http.get<Applaud[]>(this.applaudUrl + applaudProfileId + applaudImageId));
}

//reach out to the applaud API and delete the applaud in question
deleteApplaud(id : number) : Observable<Status> {
return(this.http.delete<Status>(this.applaudUrl + id));
}

}
