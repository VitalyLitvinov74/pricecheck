import {
    AdminPanelColumnSetting,
    AdminPanelElement,
    Column,
    ProductPropertySetting,
    PropertyTypeOfEntity
} from "../../../src/shared/types";

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
    return await data.json();
}