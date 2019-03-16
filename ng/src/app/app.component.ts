import {Component, OnInit} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/signIn.service";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {SignInComponent} from "./shared/sign-in-component/sign-in.component";
import {ImageService} from "./shared/services/image.service";
import {GalleryService} from "./shared/services/gallery.service";
import {GalleryCreateComponent} from "./shared/gallery-create-component/gallery-create.component";
import {AddImageComponent} from "./shared/add-image-component/add-image.component";

//TODO May need to be more like the contact form George demo'd

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html"
})
export class AppComponent{



  status : Status = null;

  constructor(protected sessionService : SessionService, private modalService : NgbModal, private signInService : SignInService, private imageService : ImageService, private galleryService : GalleryService) {
    this.sessionService.setSession()
       .subscribe(status => this.status = status);
  }
  openSignInModal() {
    const modalRef = this.modalService.open(SignInComponent);
  }
  openGalleryCreateModal() {
    const modalRef = this.modalService.open(GalleryCreateComponent);
  }
  openAddImageModal() {
    const modalRef = this.modalService.open(AddImageComponent);
  }
}
