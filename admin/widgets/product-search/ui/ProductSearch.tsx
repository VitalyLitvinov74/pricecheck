'use client'
import {useEffect, useState} from "react";
import {searchProducts} from "../api/ApiProductSearch";
import {useRouter, useSearchParams} from "next/navigation";


export default function ProductSearchWidget() {

    const searchParams = useSearchParams()
    const router = useRouter()
    const [searchPhrase, setSearchPhrase] = useState<string>(searchParams.get('searchPhrase'))

    function createQueryString(): string{
        const searchParams = new URLSearchParams();
        searchParams.set('searchPhrase', searchPhrase)
        return searchParams.toString()
    }

    return (
        <>
            <div style={{
                borderRadius: "3px",
                backgroundColor: "#fff",
                color: "#263a5b",
                display: "flex"
            }}>
                <input type="search"
                       className="form-control"
                       placeholder="Поиск по товару"
                       aria-label="Search"
                       aria-describedby="button-addon2"
                       value={searchPhrase}
                       onChange={function(event){
                           setSearchPhrase(event.target.value)
                       }}
                       onKeyDown={function(event){
                           if(event.key === 'Enter'){
                               router.push(`/products?${createQueryString()}`)
                           }
                       }}
                />
                {/*<div className="input-group-append">*/}
                {/*    <button className="btn"*/}
                {/*            type="submit"*/}
                {/*            id="button-addon2"*/}
                {/*            style={{*/}
                {/*                backgroundColor: "rgba(129, 167, 205, 0.1)",*/}
                {/*                color: "#263a5b",*/}
                {/*                fontWeight: "700",*/}
                {/*                fontSize: "18px",*/}
                {/*                borderRadius: "0 3px 3px 0",*/}
                {/*                padding: "3px 15px 3px 5px",*/}
                {/*                boxShadow: "none",*/}
                {/*            }}*/}
                {/*    >*/}
                {/*        <img*/}
                {/*            src="/assets/images/svg-icon/search.svg"*/}
                {/*            className="img-fluid"*/}
                {/*            alt="search"*/}
                {/*            style={{*/}
                {/*                width: "20px",*/}
                {/*                marginTop: '-3px',*/}
                {/*                filter: "invert(0.6) sepia(1) saturate(1) hue-rotate(185deg)",*/}
                {/*            }}*/}
                {/*        />*/}
                {/*    </button>*/}
                {/*</div>*/}
            </div>
        </>
    )
}