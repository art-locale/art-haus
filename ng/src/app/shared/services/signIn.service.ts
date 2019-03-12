import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs/Observable";
import {Status} from "../insterfaces/status";
import {SignIn} from "../interfaces/sign.in";

@Injectable()
export class SignInService {
constructor(protected http : HttpClient) {

}

//define the API endpoint for sign in
private signInUrl = "https://bootcamp-coders.cnm.edu/~bhuffman1/art-haus/public_html/api/sign-in/";

//define the API endpoint for sign out
private signOutUrl = "https://bootcamp-coders.cnm.edu/~bhuffman1/art-haus/public_html/api/sign-out/";

//perform the post to initiate sign in
postSignIn(signIn:SignIn) : Observable<Status> {
return(this.http.post<Status>(this.signInUrl, signIn));
}

getSignOut() : Observable<Status> {
return(this.http.get<Status>(this.signOutUrl));
}

}
