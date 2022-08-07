import { SmartpingObject } from '../smartping-object'

export interface InitializationConstructorProperties {
	appli: number;
}

export class Initialization extends SmartpingObject {
	readonly #authorized: boolean;

	constructor (properties: InitializationConstructorProperties) {
		super();

		this.#authorized = Boolean(properties.appli);
	}

	public authorized(): boolean {
		return this.#authorized;
	}
}
