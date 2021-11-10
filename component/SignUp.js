import React, { Component } from 'react'
import { Text, View, StyleSheet, Image, Alert, Pressable, Platform } from 'react-native'
//import {} from 'react-native-paper'
import { LinearGradient } from 'expo-linear-gradient';
import { TextInput, Button } from 'react-native-paper';
import MaterialIcons from 'react-native-vector-icons/MaterialIcons';
import { withTheme } from 'react-native-paper';
import { StatusBar } from 'expo-status-bar';
import ValidationComponent from 'react-native-form-validator';
import AwesomeAlert from 'react-native-awesome-alerts';
import axios from 'axios';
import qs from 'qs'



class SignUp extends ValidationComponent {
    constructor(props) {
        super(props)
    
        this.state = {
             email:'',
             phone:'',
             password:'',
             confirmPassword:'',
             showAlert: false,
             showModalProgress:false,
             modalTitle:'',
             modalMessage:'',
             closeOnTouchOutside:false,
             emailError:false,
             phoneError:false,
             passwordError:false,
             confirmPasswordError:false,
        }
    }
    
    _onInputChange = (field,value)=>{
        this.setState({[field]:value},()=>{
            //console.log(field);
            switch(field){

                case 'email':
                        this.validate({
                            email:{email:true,required: true},
                        });
                        this.setState({
                            emailError:this.isFieldInError('email'),
                        });
                    break;
                case 'phone':
                        this.validate({
                            phone:{required:true},
                        });
                        this.setState({
                            phoneError:this.isFieldInError('phone'),
                        });
                    break;

                case 'password':
                    this.validate({
                        password:{minlength:5, maxlength:20, required: true},
                    });
                    this.setState({
                        passwordError:this.isFieldInError('password'),
                    });
                break;

                case 'confirmPassword':
                    this.validate({
                        confirmPassword:{equalPassword: this.state.password},
                    });
                    this.setState({
                        confirmPasswordError:this.isFieldInError('confirmPassword'),
                    });
                break;
            }
        });
    }
    _onSubmit = async() => {

        this.validate({
            email:{email:true,required: true},
            phone:{required:true},
            password:{minlength:5, maxlength:20, required: true},
            confirmPassword:{equalPassword: this.state.password},
        });

        this.setState({
            emailError:this.isFieldInError('username'),
            passwordError:this.isFieldInError('password'),
            confirmPasswordError: this.isFieldInError('confirmPassword')

        });

        if(!this.isFormValid()){
            return;
        }else{
            //if form field valid
            this.setState({
                showAlert: true,
                showModalProgress:true,
                modalTitle:"",
                modalMessage:"Creating Account..",
                closeOnTouchOutside: false,
            });
            if(this.props.isConnected){
                try{
                    const params={
                            username:this.state.email,
                            email: this.state.email,
                            phone: this.state.phone,
                            password: this.state.password
                    }
                    console.log(params);
                    const response = await axios.post('https://drkeasyresume.herokuapp.com/index.php/signUp',qs.stringify(params));
                    console.log(response);
                    if(response.status === 200){
                        if(response.data.data === true){
                            console.log('reg success');
                            //this.props.changeState('isLoggedIn',true);
                        }
                        else
                            this.setState({
                                showAlert: true,
                                showModalProgress:false,
                                modalTitle:"Failed to create account",
                                modalMessage: response.data.message,
                                closeOnTouchOutside: true,
                            });

                    }else{
                        //request status is not  200
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Server error",
                            modalMessage: "Something went wrong in the server",
                            closeOnTouchOutside: true,
                        });
                    }
                }catch(error){
                    console.log(error);
                }
            }else{
                //if network is not connected
                this.setState({
                    showAlert: true,
                    showModalProgress:false,
                    modalTitle:"Ooops !",
                    modalMessage:"No Internet Connection found\n Check your connection",
                    closeOnTouchOutside: true,
                });
            }
        }
    }
    _showInputError = (fieldName) =>{
        let text='';
        this.getErrorsInField(fieldName).map((test)=>{text=text+test+'\n'})
        this.setState({
            showAlert: true,
            showModalProgress:false,
            modalTitle:"Error",
            modalMessage:text,
            closeOnTouchOutside: true,
        })
    }

    render() {
        const {colors} = this.props.theme;
        const {email,phone,password,confirmPassword,showAlert,showModalProgress,modalTitle,modalMessage,closeOnTouchOutside,emailError,phoneError,passwordError, confirmPasswordError } = this.state;
        console.log(this.state);
        return (
            <React.Fragment>
                <StatusBar style="light"/>
                <View style={styles.container}>
                    <LinearGradient
                        // Background Linear Gradient
                        colors={['rgba(245,148,183,1)', 'rgba(173,127,251,1)','rgba(146,178,253,1)']}
                        style={styles.background}
                        end={{x:0.9,y:0.9}}
                    />
                    <View>
                        <Text style={styles.headingText}>Let’s Get Started !</Text>
                        <Text style={styles.subHeadingText}> Create an account  to store  your works </Text>
                    </View>
                    <View style={styles.inputContainer}>

                        <TextInput
                            style={[styles.inputStyle]}
                            underlineColor={"transparent"}
                            label="Email"
                            value={email}
                            onChangeText = {(value)=>this._onInputChange('email',value)}
                            left={
                                <TextInput.Icon
                                name = {()=><MaterialIcons name="email" size={20} color={colors.icon}/>}
                                ></TextInput.Icon>
                            }
                            right={
                                emailError?
                                    <TextInput.Icon
                                    name = {()=>{
                                        return <Pressable onPress={()=>this._showInputError('email')}>

                                                    <MaterialIcons name="info" size={20} color='red'/>
                                                    </Pressable>}
                                        }
                                    ></TextInput.Icon>
                                :
                                null
                            }
                        />
                        <TextInput
                            style={[styles.inputStyle]}
                            underlineColor={"transparent"}
                            label="Phone"
                            value={phone}
                            onChangeText = {(value)=>this._onInputChange('phone',value)}
                            left={
                                <TextInput.Icon
                                name = {()=><MaterialIcons name="phone-android" size={20} color={colors.icon}/>}
                                ></TextInput.Icon>
                            }
                            right={
                                phoneError?
                                    <TextInput.Icon
                                    name = {()=>{
                                        return <Pressable onPress={()=>this._showInputError('phone')}>

                                                    <MaterialIcons name="info" size={20} color='red'/>
                                                    </Pressable>}
                                        }
                                    ></TextInput.Icon>
                                :
                                null
                            }
                        />
                        <TextInput
                            style={[styles.inputStyle]}
                            underlineColor={"transparent"}
                            label="Password"
                            secureTextEntry
                            value={password}
                            onChangeText = {(value)=>this._onInputChange('password',value)}
                            left={
                                <TextInput.Icon
                                name = {()=><MaterialIcons name="lock" size={20} color={colors.icon}/>}
                                ></TextInput.Icon>
                            }
                            right={
                                passwordError?
                                    <TextInput.Icon
                                    name = {()=>{
                                        return <Pressable onPress={()=>this._showInputError('password')}>

                                                    <MaterialIcons name="info" size={20} color='red'/>
                                                    </Pressable>}
                                        }
                                    ></TextInput.Icon>
                                :
                                null
                            }
                        />
                        <TextInput
                            style={[styles.inputStyle]}
                            underlineColor={"transparent"}
                            label="Confirm Password"
                            secureTextEntry
                            value={confirmPassword}
                            onChangeText = {(value)=>this._onInputChange('confirmPassword',value)}
                            left={
                                <TextInput.Icon
                                name = {()=><MaterialIcons name="lock" size={20} color={colors.icon}/>}
                                ></TextInput.Icon>
                            }

                            right={
                                confirmPasswordError?
                                    <TextInput.Icon
                                    name = {()=>{
                                        return <Pressable onPress={()=>this._showInputError('confirmPassword')}>

                                                    <MaterialIcons name="info" size={20} color='red'/>
                                                    </Pressable>}
                                        }
                                    ></TextInput.Icon>
                                :
                                null
                            }
                        />
                        <LinearGradient
                            colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                            end={{x:0.9,y:0.9}}
                            style={[styles.buttonContainer,{marginBottom:20}]}>
                            <Button style={styles.button} labelStyle={styles.buttonText} mode="text" color="#ffffff" onPress={this._onSubmit}>
                                Create
                            </Button>
                        </LinearGradient>
                        <View style={{alignItems:'center', justifyContent:'center', flexDirection:'row',marginBottom:10}}>
                            <Text style={{fontSize:16}}>Already have an account ?</Text>
                            <Pressable
                                onPress={() => this.props.openSignInPage()}>
                                <Text style={[styles.forgotPassword,{color:colors.primaryText,fontWeight:'bold'}]}> Login</Text>
                            </Pressable>
                        </View>
                    </View>
                </View>
                <AwesomeAlert
                        show={showAlert}
                        showProgress={showModalProgress}
                        progressColor="#ff00ff"
                        title={modalTitle}
                        message={modalMessage}
                        closeOnTouchOutside={closeOnTouchOutside}
                        closeOnHardwareBackPress={false}
                        showCancelButton={false}
                        showConfirmButton={false}
                        cancelText="No, cancel"
                        confirmText="Yes, delete it"
                        confirmButtonColor="#DD6B55"
                        onDismiss = {()=>{
                            this.setState({showAlert:false})
                        }}
                        onCancelPressed={() => {
                            this.hideAlert();
                        }}
                        onConfirmPressed={() => {
                            this.hideAlert();
                        }}
                        />
            </React.Fragment>
        )
    }
}

const styles = StyleSheet.create({
    container:{
        flex:1,
        justifyContent:'space-between',
        alignItems: 'center',
        paddingTop: Platform.OS ==='android' ? 40: 20,
    },
    background:{
        flex:1,
        position:'absolute',
        height:'100%',
        width:'100%',
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
        marginBottom: 25,
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


export default withTheme(SignUp)
