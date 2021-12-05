import React, {useEffect, useLayoutEffect, useState} from 'react';
import { Link } from '@inertiajs/inertia-react'

//import {Link} from '@inertiajs/inertia-react';

const Home =({name}) => {
    //const [access, setAccess] = useState('');
    //const [defaultValue, setdefaultValue] = useState('');
    console.log( name );
    return (
        <>
            <h1>Home component:</h1>
            <Link replace href="/welcome">Call Welcome</Link>
            <textarea className= "form-control" defaultValue = {JSON.stringify(name)} style={{width:'1200px', height:'600px'}} />
           <div>{JSON.stringify(name)}</div>
        </>

    );

}

export default Home;
