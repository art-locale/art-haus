import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/Observable";
import {SignUp} from "../interfaces/sign.up";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class SignUpService {
constructor(protected http: HttpClient) {}

//define the API endpoint
private signUpUrl = "https://bootcamp-coders.cnm.edu/~gkephart/ng-demo7-backend/public_html/api/";

createProfile(signUp: SignUp) : Observable<Status> {
return(this.http.post<Status>(this.signUpUrl, signUp));
}

}
