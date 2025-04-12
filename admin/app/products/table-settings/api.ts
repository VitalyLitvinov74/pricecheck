import {AdminPanelColumnSetting, PropertyTypeOfEntity} from "../../../src/shared/types";
import {uuid} from "../../../src/shared/helpers";

export async function loadColumnsSettings(propertyType: PropertyTypeOfEntity): Promise<AdminPanelColumnSetting[]> {

    const searchParams = new URLSearchParams({
        propertyTypeOfBusinessLogicEntity: propertyType
    }).toString();
    const url = `${process.env.URL}/table-settings/default/index?${searchParams}`;
    const data = await fetch(url, {
        next: {
            revalidate: 0
        }
    })
    const columnsSettings: AdminPanelColumnSetting[] = await data.json();
    return columnsSettings.map(function (columnsSetting: AdminPanelColumnSetting) {
        return {...columnsSetting, frontend_id: uuid()}
    });
}