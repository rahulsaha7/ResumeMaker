import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { AppRegistry, StyleSheet, Text, View } from 'react-native';
import { DefaultTheme, Provider as PaperProvider} from 'react-native-paper';
import  {name as appName } from './app.json';


import OnboardingScreen from './component/OnboardingScreen';
import SignIn from './component/SignIn';

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

export default function App() {
  return (
    <PaperProvider theme={theme}>
      <SignIn/>
    </PaperProvider>
  );
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