import {Gallery} from "./gallery.ts";
import {Proile} from "./profile.ts"

export interface Image {
	imageid: number,
	imageGalleryId: ?,
	imageProfileId: ?,
	imageDate: string,
	imageTitle: string,
	imageUrl: string
}