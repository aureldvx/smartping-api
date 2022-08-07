import {
	callAPI,
	FetchCallback, getResponseAsArray,
	setCredentials,
	setFetchCallback,
} from './services/smartping-core'
import { ApiEndpoints } from './enums/api-endpoints'
import { Initialization } from './models/common/initialization'
import type { InitializationConstructorProperties } from './models/common/initialization'
import Club, { ClubConstructorProperties } from './models/club/club'

export abstract class Smartping {
	protected constructor (appId: string, appKey: string, fetchWrapper: FetchCallback) {
		setCredentials(appId, appKey);
		setFetchCallback(fetchWrapper);
	}

	public async authenticate(): Promise<boolean> {
		const response = await callAPI<Initialization, InitializationConstructorProperties>({
			endpoint: ApiEndpoints.XML_INITIALISATION,
			normalizationModel: Initialization,
			rootKey: 'initialisation'
		}) as Initialization|undefined;

		return response ? response.authorized() : false;
	}

	public async findClubsByDepartment(department: number): Promise<Club[]> {
		const response = await callAPI<Club, ClubConstructorProperties>({
			endpoint: ApiEndpoints.XML_CLUB_B,
			requestParameters: {
				dep: String(department)
			},
			normalizationModel: Club,
			rootKey: 'club'
		}) as Club|Club[]|undefined;

		return getResponseAsArray(response);
	}
}


