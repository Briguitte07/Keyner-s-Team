import React from 'react';

class Menu extends React.Component {
   
    render() { 

        //creamos las variables para la carga 
        const { activeComponent, SetActiveComponent } = this.props;

        return ( 
            <div className="container">               
                <nav className='navbar navbar-expand-lg navbar-light bg-light fixed-top'>
                        <ul className='navbar-nav mr-auto'>
                            <li className='nav-item'>
                                <button className='nav-link btn btn-link'
                                onClick={()=> SetActiveComponent('usuarios')}>
                                    Usuarios
                                </button>
                            </li>
                            <li className='nav-item'>
                                <button className='nav-link btn btn-link'
                                onClick={()=> SetActiveComponent('libros')}>
                                    Libros
                                </button>
                            </li>
                            <li className='nav-item'>
                                <button className='nav-link btn btn-link'
                                onClick={()=> SetActiveComponent('facturas')}>
                                    Facturas
                                </button>
                            </li>
                            <li className='nav-item'>
                                <button className='nav-link btn btn-link'
                                onClick={()=> SetActiveComponent('proveedores')}>
                                    Proveedores
                                </button>
                            </li>                                                           
                        </ul>
                    </nav>
            </div>
            
         );
    }
}
 
export default Menu;
