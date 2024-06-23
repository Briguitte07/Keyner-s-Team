import React, { useEffect, useState } from 'react';
import {
        Button, Modal, ModalHeader, ModalBody, 
        ModalFooter, Form, FormGroup, Label, Input 
    } from 'reactstrap';

const Usuarios = () => {

    //declaracion de variables, arreglos
    const [usuarios, setCursos] = useState([]);
    const [modalOpen, setModalOpen] = useState(false);
    const [ UsuarioEditar, setUsuarioEditar] = useState(null);

    //Ejecuta funciones, renderiza la pantalla, ejecuta scripts
    useEffect(() =>{
        fetchUsuarios();
    }, []);

    

    //Declarar funciones.
    const fetchUsuarios = () =>{
        //url + listar esto es la url del servicio concatenada
        fetch( 'https://paginas-web-cr.com/Api/apis/ListaCurso.php' )
        .then(respuesta=>respuesta.json())
        .then( (datosrepuesta) => {
            setCursos(datosrepuesta.data);
        })
        .catch(
            error=>{
                console.error('Error al cargar:' , error);
            }
        );
    };


    const toggleEditModal = (curso) =>{
        setModalOpen(curso);
    };



    const guardar = async ()=>{
        // similar al fect
    }
    
    return ( 

        <div className='container'>

<br></br><br></br><br></br>


            <Button color='primary' onClick={() => toggleEditModal(true)}>
                Agregar
            </Button>

                <table
                                className="table table-info"
                            >
                               
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col">Id</th>
                                        <th scope="col">nombreUsuario</th>
                                        <th scope="col">correo</th>
                                        <th scope="col">password</th>
                                        <th scope="col">rol</th>
                                        <th scope="col">estado</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="datos">
                                    {
                                        usuarios.map( usuarios => (
                                                <tr key={usuarios.id}>
                                                    <td>Botones</td>
                                                    <td>{usuarios.id}</td>
                                                    <td>{usuarios.nombre}</td>
                                                    <td>{usuarios.correo}</td>
                                                    <td>{usuarios.password}</td>
                                                    <td>{usuarios.rol}</td>
                                                    <td>{usuarios.estado}</td>

                                                </tr>
                                        ))
                                    }


                                </tbody>
                            </table>

                        <Modal isOpen={modalOpen} >
                            <ModalHeader >Modal Usuario</ModalHeader>
                            <ModalBody>
                                <Label>Nombre</Label>
                                <Input type="text" id="nombreUsuario" value={UsuarioEditar?.nombre || ''}></Input>
                                <Label>Correo</Label>
                                <Input type="text" id="descripcion" value={UsuarioEditar?.correo || ''}></Input>
                                <Label>Password</Label>
                                <Input type="text" id="tiempo" value={UsuarioEditar?.password || ''}></Input>
                                <Label>Rol</Label>
                                <Input type="text" id="usuario" value={UsuarioEditar?.rol || ''}></Input>  
                                <Label>Estado</Label>
                                <Input type="text" id="usuario" value={UsuarioEditar?.estado || ''}></Input>                                                                                                                                                             
                            </ModalBody>
                            <ModalFooter>
                            <Button color='success' onClick={guardar}>
                                Guardar
                            </Button>
                            <Button color='danger' onClick={() => toggleEditModal(false)}>
                                Cerrar
                            </Button>


                            </ModalFooter>
                        </Modal>
        </div>



      );
}

export default CursoList;
