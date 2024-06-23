import logito from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import Menu from './misc/Menu';
import Footer from './misc/Footer';
import Usuarios from './Usuarios/Usuarios';
//import GrupoList from './grupo/GrupoList';


function App() {
  return (
    <div className="container-fluid">   
      <div className="container-fluid">   
        <Menu/>
      </div>
      <div className="container-fluid">           
        {/* { activeComponent === 'curso' && <CursoList/>}
        { activeComponent === 'grupo' && <GrupoList/>} */}
        <Usuarios/>
      </div>      
      <div className="container-fluid">   
        <Footer/>
      </div>
    </div>  
  );
}

export default App;

