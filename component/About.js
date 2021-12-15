import React, { Component } from 'react'
import { Text, View, Image,StyleSheet } from 'react-native'
import Icon from './../assets/iconTrans.png'
import Developers from './../assets/Developers.png'
export default class About extends Component {
    render() {
        return (
            <View style={styles.container}>
                <View>
                    <View style={styles.imageContainer}>
                        <Image style={styles.logo} resizeMode="contain" source={Icon}/>
                    </View>
                    <Text style={styles.version}> Version 1.0.0 </Text>

                    <Image style={styles.developers} resizeMode="contain" source={Developers}/>
                </View>
            </View>
        )
    }
}

const styles = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'center',
        alignItems:'center',
        backgroundColor:'#fff'
    },
    imageContainer:{
        alignItems:'center',
    },
    logo:{
        height:100,
        width:100
    },
    version:{
        marginTop:10,
        textAlign:'center',
        fontWeight:'700',
        fontStyle:'italic',
        color:'#555',
    },
    developers:{
        marginTop:50,
        width: 300,
        height:300,
    }
});