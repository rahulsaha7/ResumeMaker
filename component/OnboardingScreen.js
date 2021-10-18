import React, { Component } from 'react'
import {Image, View, StyleSheet } from 'react-native'
import Onboarding from 'react-native-onboarding-swiper';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { LinearGradient } from 'expo-linear-gradient';

export default class OnboardingScreen extends Component {   
  storeData = async (key,value) => {
    try {
      await AsyncStorage.setItem(key, value)
    } catch (e) {
        Alert.alert("Error","Something went wrong in the onboarding screen");
    }
  }
  hideOnBoardingScreen = ()=>{
    this.storeData('firstTime',JSON.stringify({isFirstTime:false}));
    //this.props.onStatusChange(false);
  }
  render() {
          return (
            <View style={styles.container}>
                <LinearGradient
                    // Background Linear Gradient
                    colors={['rgba(245,148,183,1)', 'rgba(173,127,251,1)','rgba(146,178,253,1)']}
                    style={styles.background}
                    end={{x:0.9,y:0.9}}
                />
              <Onboarding
                  onSkip={()=>{this.hideOnBoardingScreen()}}
                  onDone={()=>{this.hideOnBoardingScreen()}}
                  bottomBarColor="transparent"
                  bottomBarHeight={65}
                  titleStyles={{fontFamily: 'Roboto',fontWeight:'bold'}}
                  subTitleStyles = {{fontFamily: 'Roboto'}}
                  pages={[
                      {
                      backgroundColor: 'transparent',
                      image: <Image style={{height:170,width:280}} source={require('./../assets/onboarding.png')} />,
                      title: 'Easy Resume',
                      subtitle: 'Make resume in simple 3 steps',
                      }
                  ]}
                  />
            </View>
          )
  }
}

const styles = StyleSheet.create({
    container:{
        flex:1
    },
    background:{
        flex:1,
        position:'absolute',
        height:'100%',
        width:'100%',
    }
});