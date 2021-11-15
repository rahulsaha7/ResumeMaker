import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { AppRegistry, StyleSheet, Text, View } from 'react-native';
import { DefaultTheme, Provider as PaperProvider} from 'react-native-paper';
import  {name as appName } from './app.json';
import AsyncStorage from '@react-native-async-storage/async-storage';
import NetInfo from "@react-native-community/netinfo";

import OnboardingScreen from './component/OnboardingScreen';
import SignIn from './component/SignIn';
import SignUp from './component/SignUp';
import AppBar from './component/AppBar';
import Dashboard from './component/Dashboard';
import Account from './component/Account';



const theme = {
  ...DefaultTheme,
  colors:{
    ...DefaultTheme.colors,
    primary:'#92B2FD',
    accent: 'yellow',
    icon:'#F594B7',
    text:'#444444',
    primaryText:'#94AEFD'
  },
};




export default class App extends React.Component{
  constructor(props) {
    super(props)
  
    this.state = {
       firstTime: false,
       isLoggedIn: false,
       isConnected:false,
    }
  }
  

  componentDidMount(){
    this.getData();
    this.updateConnection();
  }






  updateConnection =()=> {
    NetInfo.addEventListener(state => {
      this.setState({
        isConnected:state.isConnected
      })
    });
}




/**
 * to get data from localstorage
 * @param {*} key
 */

  getData = async () => {
    console.log('test');
    try {
      const value = await AsyncStorage.getItem('firstTime');
      if(value !== null) {
        console.log(value);
        this.setState({
          firstTime: !(value === 'No'),
        })
      }else{
        this.setState({firstTime:true});
      }
    } catch(e) {
      console.log(e);
    }
  }




  /**
   * to store data in localstorage
   * 
   * @param {*} key 
   * @param {*} value 
   */

  storeData = async (key,value) => {
    try {
      await AsyncStorage.setItem(key, value)
    } catch (e) {
        Alert.alert("Error","Something went wrong in the onboarding screen");
    }
  }



  onClickStart = ()=> {
    this.setState({firstTime:false});
  }




  changeState = (key,value) =>{
    this.setState({[key]:value});
  }




  render(){
    return (
      <PaperProvider theme={theme}>
        {this.state.firstTime ? 
          <OnboardingScreen onClickStart={this.onClickStart}/>
          :
          !this.state.isLoggedIn?
            <Account isConnected={this.state.isConnected} changeState={this.changeState}/>
            :
            <Dashboard/>
        }
      </PaperProvider>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});

AppRegistry.registerComponent(appName,() => Main)