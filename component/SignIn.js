import React, { Component } from 'react'
import { Text, View, StyleSheet, Image, Alert, Pressable } from 'react-native'
//import {} from 'react-native-paper'
import { LinearGradient } from 'expo-linear-gradient';
import { TextInput, Button } from 'react-native-paper';
import MaterialIcons from 'react-native-vector-icons/MaterialIcons';
import { withTheme } from 'react-native-paper';

class SignIn extends Component {
    constructor(props) {
        super(props)
    }
    render() {
        const {colors} = this.props.theme;
        return (
            <View style={styles.container}>
                <LinearGradient
                    // Background Linear Gradient
                    colors={['rgba(245,148,183,1)', 'rgba(173,127,251,1)','rgba(146,178,253,1)']}
                    style={styles.background}
                    end={{x:0.9,y:0.9}}
                />
                <View>
                    <Image style={styles.loginImage} resizeMode="contain" source={require('./../assets/loginimage.png')}/>
                    <Text style={styles.headingText}>Welcome Back !</Text>
                    <Text style={styles.subHeadingText}> Login to your existing account </Text>
                </View>
                <View style={styles.inputContainer}>
                    <TextInput
                        style={[styles.inputStyle,{marginBottom:25}]}
                        underlineColor={"transparent"}
                        label="Username"
                        left={
                            <TextInput.Icon
                            name = {()=><MaterialIcons name="person" size={20} color={colors.icon}/>}
                            ></TextInput.Icon>
                        }
                    />
                    <TextInput
                        style={[styles.inputStyle,{marginBottom:5}]}
                        underlineColor={"transparent"}
                        label="Password"
                        secureTextEntry
                        left={
                            <TextInput.Icon
                            name = {()=><MaterialIcons name="lock" size={20} color={colors.icon}/>}
                            ></TextInput.Icon>
                        }
                    />
                    <View style={{alignItems:'flex-end'}}>
                        <Pressable
                            onPress={() => console.log('Forgot Password')}>
                            <Text style={[styles.forgotPassword,{color:colors.primaryText}]}>Forgot Password ?</Text>
                        </Pressable>
                    </View>
                    <LinearGradient
                        colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                        end={{x:0.9,y:0.9}}
                        style={[styles.buttonContainer,{marginBottom:20}]}>
                        <Button style={styles.button} labelStyle={styles.buttonText} mode="text" color="#ffffff" onPress={() => console.log('Pressed')}>
                            Log In
                        </Button>
                    </LinearGradient>
                    <View style={{alignItems:'center', justifyContent:'center', flexDirection:'row',marginBottom:10}}>
                        <Text style={{fontSize:16}}>Don’t have an account ?</Text>
                        <Pressable
                            onPress={() => console.log('Sign Up')}>
                            <Text style={[styles.forgotPassword,{color:colors.primaryText,fontWeight:'bold'}]}> Sign Up</Text>
                        </Pressable>
                    </View>
                </View>
            </View>
        )
    }
}

const styles = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'space-between',
        alignItems: 'center',
    },
    background:{
        flex:1,
        position:'absolute',
        height:'100%',
        width:'100%',
    },
    loginImage:{
        width:200,
    },
    headingText:{
        fontSize: 25,
        color: '#ffffff',
        fontWeight:'bold',
        fontFamily: 'Roboto',
        textAlign:'center',
    },
    subHeadingText:{
        fontSize: 16,
        color: '#ffffff',
        fontWeight:'normal',
        fontFamily: 'Roboto',
        textAlign:'center',
    },
    inputContainer:{
        borderTopLeftRadius: 40,
        borderTopRightRadius: 40,
        paddingTop: 44,
        paddingLeft:30,
        paddingRight:30,
        width:'100%',
        backgroundColor: '#ffffff',
    },
    inputStyle:{
        height:50,
        backgroundColor:'#ffffff',
        borderRadius:40,
        borderTopRightRadius:40,
        borderTopLeftRadius:40,
        elevation:2,
        overflow:'hidden',
    },
    buttonContainer:{
        borderRadius:40,
        padding:9,
        marginLeft: 40,
        marginRight: 40,
    },
    button:{
        backgroundColor:'transparent'
    },
    buttonText:{
        fontSize: 16,
        fontWeight: 'bold',
        fontFamily: 'Roboto',
    },
    forgotPassword:{
        fontSize: 16,
        marginVertical: 5,
    }
});


export default withTheme(SignIn)
