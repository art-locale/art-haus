import {Component, OnInit} from "@angular/core";
import {GalleryService} from "../shared/services/gallery.service";
import {Gallery} from "../shared/interfaces/gallery";
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
// import {repeat} from "rxjs/operators";
import {Status} from "../shared/interfaces/status";
// import {el} from "@angular/platform-browser/testing/src/browser_util";

@Component({
	templateUrl: "gallery.view.component.html"
})

export class GalleryViewComponent implements OnInit{
	//create state variable to house all data
	gallery : Gallery[] = [];
	creatGalleryForm : FormGroup;
	status: Status = new Status(null, null, null);
	constructor(private galleryService: GalleryService, private formBuilder : FormBuilder) {}

	//call onInit above to work (fulfill the contract)
	ngOnInit(): void {
		this.creatGalleryForm = this.formBuilder.group({
			galleryName: ["", [Validators.maxLength(32), Validators.required]],
			galleryTitle: ["", [Validators.maxLength(64), Validators.required]]
		});
		this.loadPosts();
	}

	loadPosts() {
		this.postService.getAllPosts().subscribe(reply => this.posts = reply);
	}

	createPosts(){
		let post: Post = {postId: null, postContent: this.creatPostForm.value.postContent, postDate: null, postTitle: this.creatPostForm.value.postTitle};
		this.postService.createPost(post).subscribe(reply => {
			this.status = reply;
			if(this.status.status === 200) {
				alert("Yay post created");
				this.loadPosts();
			} else{
				alert("who taught how to type...");
			}
		})
	}

}