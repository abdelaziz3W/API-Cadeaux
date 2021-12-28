import axios from 'axios'
import React, {useEffect, useState} from 'react'
import * as ReactBootStrap from 'react-bootstrap'





const Table = () => {
    const [posts, setPosts] = useState([]);
    //const [stock, setStock] = useState([]);

     //Get data from json Placeholder
     const fetchUrl = "http://localhost:8080/API/api/read"

     useEffect(()=>{
         async function fetchData() {
             const data = await axios.post(fetchUrl)
             console.log(data)
             setPosts(data.data.body)
         }
         fetchData()
     }, [fetchUrl])
         //console.table(posts);


        function updateStock ( id, stock){
            const data = {
                id, 
                stock
            }
            console.log(data)

        axios.post('http://localhost:8080/API/api/update.php/', data).then(res=>{
                console.log(res);
            if(res.data.status === 200) {
                console.log("Success",res.data.message,"success");
            }
    
            });
        }  

       // stock === post.stock;
       const handleDecrement = (cadeau_id) => { 
           let postStock; 
        setPosts(posts => posts.map((post) =>
            cadeau_id === post.id ? {...post, stock: post.stock - (post.stock > 1 ? 1 : 0)} : post
        )) 
        posts.forEach(post=> {
            if (post.id === cadeau_id) {
                postStock=post.stock - 1;
            }
        })
        console.table(cadeau_id, postStock)
        updateStock(cadeau_id, postStock)
    
    }
        const handleIncrement = (cadeau_id ) => {
            let postStock; 
            setPosts(posts => posts.map((post) =>
            cadeau_id === post.id ? {...post, stock: parseInt(post.stock)  + (post.stock < 100 ? 1 : 0)} : post
        )) 
        posts.forEach(post=> {
            if (post.id === cadeau_id) {
                postStock=post.stock + 1;
            }
        })
        console.table(cadeau_id, postStock)
        updateStock(cadeau_id, postStock)
    
    }
    

    return (
        <div>
            <h2>Cadeaux</h2>
            <ReactBootStrap.Table striped bordered hover>
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Nom Cadeau</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {posts.map((post) =>
                        <tr key={post.id}>
                            <td>{post.id}</td>
                            <td>{post.nom}</td>
                            <td>{post.description}</td>
                            <td>{post.stock}</td>
                            <td> 
                                <button type="button" className="btn btn-outline-success" onClick={ ()=> handleIncrement(post.id) }>Ajouter</button>
                                <button type="button" className="btn btn-outline-danger" onClick={ ()=> handleDecrement(post.id) } >Supprimer</button>
                    
                            </td>
                        </tr>
                        )
                    }
                    
                </tbody>
            </ReactBootStrap.Table>
            
        </div>
    )


}



export default Table;