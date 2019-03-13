import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
import {SignUp} from "../interfaces/sign.up";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable()
export class SignUpService {
constructor(protected http: HttpClient) {}

//define the API endpoint
private signUpUrl = "https://bootcamp-coders.cnm.edu/~bhuffman1/art-haus/public_html/api/sign-up/";

createProfile(signUp: SignUp) : Observable<Status> {
return(this.http.post<Status>(this.signUpUrl, signUp));
}

}
