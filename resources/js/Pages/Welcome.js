import React, {useEffect, useLayoutEffect, useState} from 'react';
import {Link} from "@inertiajs/inertia-react";
//import {Link} from '@inertiajs/inertia-react';

const Welcome =({foo}) => {
    //const [access, setAccess] = useState('');
    //const [defaultValue, setdefaultValue] = useState('');
    console.log( foo);
    return (
        <>
            <h1>Welcome component:</h1>
            <Link replace href="/home">Call home</Link>
            <textarea className= "form-control" defaultValue = {JSON.stringify(foo)} style={{width:'1200px', height:'600px'}} />
           <div>{JSON.stringify(foo)}</div>
        </>

    );

}

export default Welcome;
