import {Gallery} from "./gallery";
import {Profile} from "./profile"

export interface Image {
	imageId: number,
	imageGalleryId: number,
	imageProfileId: number,
	imageDate: string,
	imageTitle: string,
	imageUrl: string
}