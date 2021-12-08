import React, { Component } from 'react'
import { Text, View, StyleSheet,Dimensions } from 'react-native'
import { LinearGradient } from 'expo-linear-gradient';

export default class Loading extends Component {
    
    render() {
        const windowWidth = Dimensions.get('window').width;
        const windowHeight = Dimensions.get('window').height;
        return (
            <View style={{}}>
                <LinearGradient
                    colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                    end={{x:0.9,y:0.9}}
                    style={[styles.linearGradient,{height:windowHeight,width:windowWidth}]}
                    >
                    <View style={styles.container}>
                        <Text>Splash Screen</Text>
                    </View>
                </LinearGradient>

            </View>
        )
    }
}

const styles = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'center',
        alignItems:'center',
    },
    linearGradient:{
        position:'absolute',
    }
})