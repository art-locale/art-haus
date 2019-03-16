import {Component, OnInit} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/signIn.service";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {SignInComponent} from "./sign-in.component";

//TODO May need to be more like the contact form George demo'd

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html"
})
export class AppComponent{



  status : Status = null;

  constructor(protected sessionService : SessionService, private modalService : NgbModal, private signInService: SignInService) {
    this.sessionService.setSession()
       .subscribe(status => this.status = status);
  }
  openSignInModal() {
    const modalRef = this.modalService.open(SignInComponent);
  }
}
